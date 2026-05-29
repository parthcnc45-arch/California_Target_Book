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
        $data = $request->all();
        $this->validator($data)->validate();

        $user = $this->createUser($data);

        event(new Registered($user));

        if ($data['is_paid_for']) {
            $token = Password::broker()->createToken($user);
            dispatch(new SendSetPassword($user, $token));
        } else {
            // Send base account payment instructions
            dispatch(new SendPaymentInstructionsEmail($user));
        }

        return $user;
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
