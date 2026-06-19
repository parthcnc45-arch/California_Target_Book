<?php

/**
 * Users controller for api
 * Meant for admin
 */

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Jobs\SendSetPassword;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendPaymentInstructionsEmail;
use App\Http\Controllers\Traits\CreatesUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{

    use CreatesUser;

    // List all users
    public function index()
    {
        return new UserCollection(User::orderBy('created_at', 'desc')->get());
    }

    // Get user by id
    public function get($id, Request $request)
    {
        if ($id == "me") {
            return new UserResource($request->user());
        }
        return new UserResource(User::find($id));
    }

    public function create(Request $request)
    {
        @set_time_limit(180);
        $data = $request->all();
        \Illuminate\Support\Facades\Log::info('Admin User Create Request Data:', $data);
        $this->validator($data)->validate();

        // 2. Now create the user in Laravel DB and Stripe Subscription
        $user = $this->createUser($data);

        $response = response()->json($user);

        if (function_exists('fastcgi_finish_response')) {
            \Illuminate\Support\Facades\Session::save();
            $response->send();
            fastcgi_finish_response();

            // Run GHL sync & email dispatching in background
            $this->runAdminBackgroundTasks($user, $data);
        } else {
            // Fallback for local
            $this->runAdminBackgroundTasks($user, $data);
            return $response;
        }
    }

    /**
     * Run GHL Sync and Email dispatching in background process for admin creations.
     */
    private function runAdminBackgroundTasks($user, $data)
    {
        // 1. Sync GHL Contact
        try {
            dispatch_now(new \App\Jobs\SyncGHLContact($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('SyncGHLContact failed in background (admin): ' . $e->getMessage());
        }

        // 2. Trigger Registered event
        event(new Registered($user));

        // 3. Dispatch credentials or instructions
        if ($data['is_paid_for']) {
            $token = Password::broker()->createToken($user);
            dispatch_now(new SendSetPassword($user, $token));
        } else {
            // Send base account payment instructions
            dispatch_now(new SendPaymentInstructionsEmail($user->id));
        }
    }

    private function validator($data)
    {
        return $this->create_user_validator($data, [
            // Overrides
            'phone_number' => 'nullable|digits:10',

            // Extra admin options
            'subscription_cost' => 'required|numeric|min:0',
            'book_cost' => 'required|numeric|min:0',
            'addon_cost' => 'required|numeric|min:0',
            'is_paid_for' => 'required|boolean',
            'send_invoice' => 'required|boolean',
        ]);
    }

    public function update(Request $request, $id) {
        $validation = [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'string|email',
            'company' => 'string|nullable',
            'phone_number' => 'string|nullable',
            'notes' => 'string|nullable',
            'role' => [ 'string', Rule::in(User::VALID_ROLES) ],
        ];

        $data = $request->only(array_keys($validation));
        $val = Validator::make($data, $validation);
        $val->validate();

        $user = User::find($id);
        $user->update($data);

        return new UserResource($user);
    }

    public function updatePassword(Request $request, $id) {
        $validation = [ 'password' => 'string|confirmed|min:6|max:255' ];
        $data = $request->all();
        $val = Validator::make($data, $validation);
        $val->validate();

        $user = User::find($id);
        $user->password = bcrypt($data['password']);
        $user->save();

        return new UserResource($user);
    }

}
