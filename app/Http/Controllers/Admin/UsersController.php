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
        $data = $request->all();
        \Illuminate\Support\Facades\Log::info('Admin User Create Request Data:', $data);
        $this->validator($data)->validate();

        // 1. Get or Create GoHighLevel Contact first to avoid race conditions and match Stripe perfectly
        $ghlContactId = null;
        try {
            $tempUser = (object) [
                'first_name' => $data['first_name'] ?? '',
                'last_name'  => $data['last_name'] ?? '',
                'email'      => $data['email'] ?? '',
                'phone'      => $data['phone_number'] ?? '',
            ];
            $ghlContactId = $this->getOrCreateGHLContact($tempUser);
            if ($ghlContactId) {
                $data['ghl_contact_id'] = $ghlContactId;
            }
        } catch (\Exception $e) {
            Log::error('GoHighLevel Pre-Sync Contact Error in UsersController:create: ' . $e->getMessage());
        }

        // 2. Now create the user in Laravel DB and Stripe Subscription
        $user = $this->createUser($data);

        if ($ghlContactId) {
            Log::info('GHL Contact successfully synchronized in UsersController:create', [
                'user_id' => $user->id,
                'ghl_contact_id' => $ghlContactId,
            ]);
        }

        event(new Registered($user));

        if ($data['is_paid_for']) {
            $token = Password::broker()->createToken($user);
            dispatch(new SendSetPassword($user, $token));
        } else {
            // Send base account payment instructions
            dispatch(new SendPaymentInstructionsEmail($user->id));
        }

        return $user;
    }

    private function getOrCreateGHLContact($user)
    {
        $ghlToken   = config('app.GHL_TOKEN') ?? 'pit-9edbcb56-3ea3-4e72-b633-a54a943ec8cf';
        $locationId = config('app.GHL_LOCATION_ID') ?? 'Fvvh7SvvoDgMQg4PNPCB';

        // Try creating contact with Active Subscriber tags
        $payload = [
            'locationId' => $locationId,
            'firstName'  => $user->first_name ?? '',
            'lastName'   => $user->last_name ?? '',
            'email'      => $user->email,
            'phone'      => $user->phone_number ?? $user->phone ?? '',
            'tags'       => ['active_subscriber', 'CTB Active'],
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer $ghlToken",
            'Version'       => '2021-07-28',
            'Accept'        => 'application/json',
        ])->post('https://services.leadconnectorhq.com/contacts/', $payload);

        $resData = $response->json();

        Log::info('GHL Contact getOrCreate response', [
            'status' => $response->status(),
            'response' => $resData
        ]);

        $contactId = $resData['contact']['id'] ?? $resData['id'] ?? $resData['meta']['contactId'] ?? null;

        // If creation failed or didn't return contact ID (e.g. contact already exists)
        if (!$contactId) {
            // Try to lookup/search contact by email
            $searchResponse = Http::withHeaders([
                'Authorization' => "Bearer $ghlToken",
                'Version'       => '2021-07-28',
                'Accept'        => 'application/json',
            ])->get('https://services.leadconnectorhq.com/contacts/', [
                'locationId' => $locationId,
                'query' => $user->email
            ]);

            $searchData = $searchResponse->json();
            Log::info('GHL Contact search response', [
                'status' => $searchResponse->status(),
                'response' => $searchData
            ]);

            $contacts = $searchData['contacts'] ?? [];
            if (!empty($contacts)) {
                $contactId = $contacts[0]['id'] ?? null;
            }
        }

        // If contact already existed, let's update it to add the active_subscriber tags
        if ($contactId && ($response->status() === 400 || !empty($contacts))) {
            Http::withHeaders([
                'Authorization' => "Bearer $ghlToken",
                'Version'       => '2021-07-28',
                'Accept'        => 'application/json',
            ])->put("https://services.leadconnectorhq.com/contacts/{$contactId}", [
                'tags' => ['active_subscriber', 'CTB Active']
            ]);
        }

        return $contactId;
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
