<?php
namespace App\Http\Controllers\Auth;

use App\Events\NewSubscriber;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CreatesUser;
use App\Jobs\SendAddonInvitation;
use App\Jobs\SendPaymentInstructionsEmail;
use App\Jobs\SendVerificationEmail;
use App\Jobs\SendSetPassword;
use Illuminate\Support\Facades\Log;

use App\User;
use DebugBar\DebugBar;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use CreatesUser;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('submitSubscription');
    }
    public function testLog(Request $request){
        Log::info('Incoming Request [testLog]:', $request->all());

        $payload = $request->all();
        
        // Clean up 'null' strings to real nulls
        foreach ($payload as $key => $value) {
            if ($value === 'null') {
                $payload[$key] = null;
            }
        }

        $fullName = $payload['full_name'] ?? 'User Name';
        $names = explode(' ', $fullName, 2);
        $firstName = $names[0] ?? 'User';
        $lastName = $names[1] ?? 'Name';

        // Prepare data for trait method
        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $payload['email'] ?? '',
            'phone_number' => $payload['phone_number'] ?? '',
            'password' => $payload['password'] ?? null,
            'company' => [
                'name' => $payload['company_name'] ?? 'Company Name',
                'address' => [
                    'line1' => $payload['company_address'] ?? 'Address Line 1',
                    'city' => 'N/A',
                    'state' => 'N/A',
                    'zip_code' => '00000',
                ]
            ],
            'subscription_length' => 12, // Default to 12 months
            'payment_method' => 'stripe',
            'stripe_token' => null,
            'status' => 'active',
            'wordpress_subscription_id' => $payload['subscription_id'] ?? null,
            'subscription_cost' => $payload['order_total'] ?? 0,
            'register_by' => 'api_testlog',
            'is_paid_for' => true,
            'send_invoice' => false,
            'contact_id' => $payload['contact_id'] ?? null,
        ];

        try {
            // Updated to call the new method defined in CreatesUser trait
            $user = $this->createUserAndSubscription($data);

            return new JsonResponse([
                'success' => true,
                'message' => 'User and subscription processed successfully via trait',
                'user_id' => $user->id,
                'email' => $user->email
            ]);

        } catch (\Exception $e) {
            Log::error('Error in testLog processing: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return new JsonResponse([
                'success' => false,
                'message' => 'Failed to process request: ' . $e->getMessage()
            ], 500);
        }
    }
    public function createNewSubscription(Request $request){
        return new JsonResponse(['success'=>true,'message'=>'Thank you for Subscription']);
    }
    public function register_api(Request $request){
        $data = $request->except(CreatesUser::$create_user_admin_options);
        $data['register_by'] = 'wordpress';
        $data['is_paid_for'] = true;
        // defined in CreatesUser
        $data['send_invoice'] = true;
       
        $user = $this->createUser($data);
        return new JsonResponse(['success'=>true,'message'=>'Thank you for Subscription','userData'=>$user]);
    }
    public function updateeuser_api(Request $request){
        $data = $request->except(CreatesUser::$create_user_admin_options);
        $user = $this->updateUser($data);
        return new JsonResponse(['success'=>true,'message'=>'Update user data successfully','userData'=>$user]);
    }
    public function updateSubscriptionStatusAPI(Request $request){
        $subscription_id = $request->input('wordpress_subscription_id');
        $status = $request->input('status');
        $next_payment_date = $request->input('next_payment_date');
        $end_date = $request->input('end_date');
        $user = $this->updateSubscriptionStatus($subscription_id,$status,$next_payment_date,$end_date);
        return new JsonResponse(['success'=>true,'message'=>'Subscription status updated successfully','Data'=>$user]);
    }

    /**
     * GHL Subscription Webhook
     * Called by GoHighLevel when a subscription status changes.
     * Since GHL doesn't send the status in the webhook payload,
     * we call the GHL Subscription API to fetch the current status.
     */
    public function ghlSubscriptionWebhook(Request $request)
    {
        Log::info('GHL Subscription Webhook received:', $request->all());

        $payload = $request->all();

        // GHL may send subscription ID in different fields
        $ghlSubscriptionId = $payload['subscriptionId']
            ?? $payload['subscription_id']
            ?? $payload['id']
            ?? $payload['_id']
            ?? null;

        if (empty($ghlSubscriptionId)) {
            Log::warning('GHL Webhook: No subscription ID found in payload');
            return new JsonResponse([
                'success' => false,
                'message' => 'No subscription ID provided',
            ], 400);
        }

        // Find the Laravel subscription by the GHL subscription ID
        $subscription = \App\Subscription::where('wordpress_subscription_id', $ghlSubscriptionId)->first();

        if (!$subscription) {
            Log::warning('GHL Webhook: No matching subscription found', [
                'ghl_subscription_id' => $ghlSubscriptionId,
            ]);
            return new JsonResponse([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        // Call GHL API to get the actual subscription status
        $ghlToken   = config('app.GHL_TOKEN') ?? 'pit-9edbcb56-3ea3-4e72-b633-a54a943ec8cf';
        $locationId = 'Fvvh7SvvoDgMQg4PNPCB';

        try {
            $ghlResponse = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => "Bearer $ghlToken",
                'Version'       => '2021-07-28',
                'Accept'        => 'application/json',
            ])->get("https://services.leadconnectorhq.com/payments/subscriptions/{$ghlSubscriptionId}/", [
                'altId'   => $locationId,
                'altType' => 'location',
            ]);

            if (!$ghlResponse->successful()) {
                Log::error('GHL Webhook: Failed to fetch subscription from GHL API', [
                    'ghl_subscription_id' => $ghlSubscriptionId,
                    'status'              => $ghlResponse->status(),
                    'body'                => $ghlResponse->body(),
                ]);
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Failed to fetch subscription status from GHL',
                ], 500);
            }

            $ghlData = $ghlResponse->json();

            Log::info('GHL Webhook: Subscription detail fetched', [
                'ghl_subscription_id' => $ghlSubscriptionId,
                'ghl_status'          => $ghlData['status'] ?? 'unknown',
            ]);

        } catch (\Exception $e) {
            Log::error('GHL Webhook: API call failed', [
                'error' => $e->getMessage(),
            ]);
            return new JsonResponse([
                'success' => false,
                'message' => 'GHL API error: ' . $e->getMessage(),
            ], 500);
        }

        // Map GHL status to Laravel status
        $ghlStatus = strtolower($ghlData['status'] ?? '');
        $statusMap = [
            'active'              => 'active',
            'completed'           => 'active',
            'trialing'            => 'active',
            'past_due'            => 'pending',
            'unpaid'              => 'pending',
            'paused'              => 'expired',
            'cancelled'           => 'expired',
            'canceled'            => 'expired',
            'expired'             => 'expired',
            'incomplete'          => 'pending',
            'incomplete_expired'  => 'expired',
        ];

        $newStatus = $statusMap[$ghlStatus] ?? $ghlStatus;

        // Update subscription status
        $oldStatus = $subscription->status;
        $subscription->status = $newStatus;

        // Update dates from GHL subscription snapshot if available
        $snapshot = $ghlData['subscriptionSnapshot'] ?? [];
        if (!empty($snapshot['current_period_end'])) {
            // Convert Unix timestamp to date string
            $endDate = date('Y-m-d', $snapshot['current_period_end']);
            $subscription->next_payment = $endDate;
            $subscription->end_date = $endDate;
        }

        $subscription->save();

        // Update the latest cycle based on new status
        if (in_array($newStatus, ['expired'])) {
            $cycle = $subscription->getLatestCycle();
            if ($cycle) {
                // Set ends_on to yesterday so isActive() and isCurrent() return false immediately
                $cycleEndDate = now()->subDay()->toDateString();
                $cycle->update(['ends_on' => $cycleEndDate]);
            }
        }

        // Activate cycle if status changed to active
        if ($newStatus === 'active' && $oldStatus !== 'active') {
            $cycle = $subscription->getLatestCycle();
            if ($cycle) {
                $cycle->activate();
            }
        }

        Log::info('GHL Webhook: Subscription status updated', [
            'ghl_subscription_id'     => $ghlSubscriptionId,
            'laravel_subscription_id' => $subscription->id,
            'ghl_status'              => $ghlStatus,
            'old_status'              => $oldStatus,
            'new_status'              => $newStatus,
        ]);

        return new JsonResponse([
            'success' => true,
            'message' => 'Subscription status updated successfully',
            'data' => [
                'subscription_id' => $subscription->id,
                'ghl_status'      => $ghlStatus,
                'old_status'      => $oldStatus,
                'new_status'      => $newStatus,
            ],
        ]);
    }

    public function deleteuser_api(Request $request){
        // Retrieve email from the request
        $email = $request->input('email');
        // Find the user by email
        $user = User::where('email', $email)->first();
        if ($user) {
            $delete_user = $this->deleteuseapi($user);
            return response()->json([
                'success' => true,
                'type'=>$delete_user['type'],
                'users'=>$delete_user['users'],
                'message' => 'User deleted successfully.',
            ], 200);
            } else {
                // User not found
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
        }

    }
    public function register(Request $request)
    {
        // Get all data except admin options
        $data = $request->except(CreatesUser::$create_user_admin_options);

        // defined in CreatesUser
        $this->create_user_validator($data)->validate();

        // Default options
        $data['send_invoice'] = true;

        $user = $this->createUser($data);

        event(new Registered($user));
        event(new NewSubscriber($user));

        if (array_key_exists('is_paid_for',$data) && $data['is_paid_for']) {
            dispatch(new SendVerificationEmail($user->id));
        } else {
            dispatch(new SendPaymentInstructionsEmail($user->id));
        }

        try {
            $invoice = \Stripe\Invoice::retrieve(
                $user->latestSubscription()->cycles()->first()->invoice_id
            );
        } catch (\Exception $e) {
            Log::error($e);
            $invoice = null;
        }

        Session::put('new_subscription', [
            'user' => $user,
            'invoice' => $invoice,
        ]);
        return $request->wantsJson()
        ? new JsonResponse(['success'=>true,'message'=>'Thank you for Subscription'], 200)
        : redirect()->route('register.thank-you');

        // return redirect()->route('register.thank-you');
    }

    /**
     * Verify a new user via email
     *  Once base account is confirmed,
     *  send invites to add on accounts
     */
    public function verify($token)
    {
        $user = User::where('email_token', $token)->first();
        $user->verified = 1;

        // Send verification email to base account's add ons
        $user->activeSubscription()->addons()
            ->get()
            ->each(function ($addon) use ($user) {
                dispatch(new SendAddonInvitation($user, $addon));
            });

        if ($user->save()) {
            return redirect()
                ->route('login')
                ->withInput(['email' => $user->email])
                ->with('message', 'Your email has been verified. Please Log in.');
        }
    }

    public function verify_addon($token)
    {
        return view('auth.register-addon', [
            'user' => User::where('email_token', $token)->first(),
        ]);
    }

    public function register_addon(Request $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ])->validate();

        $user = User::where('email_token', $data['token'])->first();

        $user->verified = 1;
        $user->password = bcrypt($data['password']);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];

        if ($user->save()) {

            event(new Registered($user));

            $this->guard()->login($user);

            return redirect()->route('book')
                ->with('message', 'Your account has been created successfully.');
        }
    }

    public function showThankYou(Request $request) {
        $data = Session::get('new_subscription');

        if (empty($data)) {
            return redirect()->route('register');
        }

        if ($request->query('resend', false)) {
            if ($data['invoice'] && $data['invoice']->paid) {
                dispatch(new SendVerificationEmail($data['user']));
            } else {
                dispatch(new SendPaymentInstructionsEmail($data['user']));
            }
        }

        return view('auth.thank-you', [
            'invoice' => $data['invoice'],
            'registrationEmailResend' => $request->query('resend', false),
        ]);
    }

    public function checkCoupon($code) {
        $c = trim(strtolower($code));
        $validCodes = ['freetrial'];

        return [
            'code' => $c,
            'valid' => in_array($c, $validCodes),
        ];
    }

    public function signup(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'company' => 'nullable|string|max:255',
        ]);

        $nameParts = explode(' ', $validated['name'], 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $companyId = null;
        if (!empty($validated['company'])) {
            $company = \App\Company::firstOrCreate(['name' => $validated['company']]);
            
            // Create an empty address and link it if the company doesn't have one
            if (!$company->address_id) {
                $address = \App\Address::create([
                    'line1' => '',
                    'line2' => '',
                    'city' => '',
                    'state' => '',
                    'zip_code' => '',
                    'special_instructions' => '',
                ]);
                $company->address_id = $address->id;
                $company->save();
            }
            
            $companyId = $company->id;
        }

        $user = \App\User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'company_id' => $companyId,
            'register_by' => "laravel",
        ]);

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function submitSubscription(Request $request)
    {
        $data = $request->all();
        \Illuminate\Support\Facades\Log::info('Public Subscription Create Request Data:', $data);
        
        $this->create_user_validator($data)->validate();

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
            Log::error('GoHighLevel Pre-Sync Contact Error in RegisterController:submitSubscription: ' . $e->getMessage());
        }

        // 2. Now create the user in Laravel DB and Stripe Subscription
        $user = $this->createUser($data);

        if ($ghlContactId) {
            Log::info('GHL Contact successfully synchronized in RegisterController:submitSubscription', [
                'user_id' => $user->id,
                'ghl_contact_id' => $ghlContactId,
            ]);
        }

        event(new Registered($user));
        event(new NewSubscriber($user));

        if (!empty($data['is_paid_for'])) {
            $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);
            dispatch(new SendSetPassword($user, $token));
        } else {
            // Send base account payment instructions
            dispatch(new SendPaymentInstructionsEmail($user->id));
        }

        return response()->json(['success' => true, 'user' => $user]);
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

        $response = \Illuminate\Support\Facades\Http::withHeaders([
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
            $searchResponse = \Illuminate\Support\Facades\Http::withHeaders([
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
            \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => "Bearer $ghlToken",
                'Version'       => '2021-07-28',
                'Accept'        => 'application/json',
            ])->put("https://services.leadconnectorhq.com/contacts/{$contactId}", [
                'tags' => ['active_subscriber', 'CTB Active'],
            ]);
        }

        return $contactId;
    }
}
