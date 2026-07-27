<?php
namespace App\Http\Controllers\Auth;

use App\Events\NewSubscriber;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CreatesUser;
use App\Jobs\SendAddonInvitation;
use App\Jobs\SendPaymentInstructionsEmail;
use App\Jobs\SendVerificationEmail;
use App\Jobs\SendSetPassword;
use App\Jobs\SendInvoice;
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
        $this->middleware('guest')->only('showRegistrationForm');
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
        @set_time_limit(180);
        // Get all data except admin options
        $data = $request->except(CreatesUser::$create_user_admin_options);

        $rules = [];
        if (!Auth::check()) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        // defined in CreatesUser
        $this->create_user_validator($data, $rules)->validate();

        $userEmail = $data['email'] ?? null;
        $userExists = false;
        $isVerified = false;
        if ($userEmail) {
            $existingUser = User::where('email', $userEmail)->first();
            if ($existingUser) {
                $userExists = true;
                $isVerified = (int)$existingUser->verified === 1;
            }
        }

        // Default options
        $data['send_invoice'] = true;

        $user = $this->createUser($data);

        // Log in the user if guest checks out
        if (!Auth::check()) {
            Auth::login($user);
        }

        try {
            $invoice = \Stripe\Invoice::retrieve(
                $user->latestSubscription()->cycles()->first()->invoice_id
            );
        } catch (\Exception $e) {
            Log::error($e);
            $invoice = null;
        }

        // Store registration info in session for the background emails API
        Session::put('new_subscription', [
            'user' => $user,
            'invoice' => $invoice,
            'userExists' => $userExists,
            'isVerified' => $isVerified,
            'plainPassword' => $request->input('password'),
            'data' => $data,
        ]);
        Session::save();

        return $request->wantsJson()
        ? new JsonResponse(['success'=>true,'message'=>'Thank you for Subscription'], 200)
        : redirect()->route('register.thank-you');
    }

    /**
     * Web API called asynchronously to send GHL and registration emails in the background.
     */
    public function sendRegistrationEmailsAPI(Request $request)
    {
        $sessionData = Session::get('new_subscription');
        if (!$sessionData) {
            return new JsonResponse(['success' => false, 'message' => 'No active registration session found.'], 400);
        }

        $user = $sessionData['user'];
        $invoice = $sessionData['invoice'];
        $userExists = $sessionData['userExists'] ?? false;
        $isVerified = $sessionData['isVerified'] ?? false;
        $plainPassword = $sessionData['plainPassword'] ?? null;
        $data = $sessionData['data'] ?? [];

        // 1. Sync GHL Contact
        try {
            dispatch_now(new \App\Jobs\SyncGHLContact($user));
        } catch (\Exception $e) {
            Log::error('SyncGHLContact failed in API: ' . $e->getMessage());
        }

        // 2. Dispatch emails
        if (array_key_exists('is_paid_for', $data) && $data['is_paid_for']) {
            if (!$userExists) {
                // New user
                if (empty($plainPassword)) {
                    // Checkout flow without password field -> send Set Password link
                    $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);
                    dispatch_now(new SendSetPassword($user, $token));
                } else {
                    // Standard registration page -> send standard verification email
                    dispatch_now(new SendVerificationEmail($user->id));
                }
            } else {
                // Existing user
                if (!$isVerified) {
                    dispatch_now(new SendVerificationEmail($user->id));
                }
            }
        } else {
            // Unpaid (e.g. check/invoice payment) -> send instructions
            dispatch_now(new SendPaymentInstructionsEmail($user->id));
        }

        // 3. Dispatch Invoice email
        if (isset($invoice) && isset($data['send_invoice']) && $data['send_invoice']) {
            dispatch_now(new SendInvoice($user, $invoice));
        }

        // 4. Trigger events (e.g., admin notifications)
        event(new Registered($user));
        event(new NewSubscriber($user));

        return new JsonResponse(['success' => true, 'message' => 'Emails processed successfully.']);
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

    public function purchaseBookOnly(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:50',
            'password' => 'nullable|string|min:6|confirmed',
            'stripe_token' => 'required|string',
            'custom_total_amount' => 'required|numeric|min:50', // in cents
            'deck_addresses' => 'array',
            'deck_addresses.*.line1' => 'required|string|max:255',
            'deck_addresses.*.line2' => 'nullable|string|max:255',
            'deck_addresses.*.city' => 'required|string|max:255',
            'deck_addresses.*.state' => 'required|string|max:255',
            'deck_addresses.*.zip_code' => 'required|string|max:255',
            'deck_addresses.*.special_instructions' => 'nullable|string|max:255',
            'deck_title' => 'nullable|string|max:255',
            'deck_types' => 'nullable|array',
        ]);

        $email = $validated['email'];
        $user = User::where('email', $email)->first();

        // Dynamically build the transaction description based on chosen items
        $selectedNames = [];
        $deckTypes = $validated['deck_types'] ?? [];
        if (!empty($deckTypes) && is_array($deckTypes)) {
            foreach ($deckTypes as $type) {
                if ($type == config('subscriptions.deck_only')) {
                    $selectedNames[] = config('subscriptions.names.deck_only', 'Post-Election Deck Only');
                } elseif ($type == config('subscriptions.deck_presentation') . '_presentation') {
                    $selectedNames[] = config('subscriptions.names.deck_presentation', 'Post-Election Presentation');
                } elseif ($type == config('subscriptions.additional_printed_book') . '_book') {
                    $selectedNames[] = config('subscriptions.names.additional_printed_book', 'Additional Printed Book');
                }
            }
        }
        $txDesc = !empty($selectedNames) ? implode(', ', $selectedNames) : ($validated['deck_title'] ?? 'Post-Election Deck/Book Purchase');

        // 1. Create or Update User
        if (!$user) {
            $password = !empty($validated['password']) ? bcrypt($validated['password']) : bcrypt(\Illuminate\Support\Str::random(10));
            // Find or create default company
            $company = \App\Company::firstOrCreate(['name' => 'None']);
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
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $email,
                'phone_number' => $validated['phone_number'],
                'password' => $password,
                'company_id' => $company->id,
                'register_by' => 'laravel',
                'verified' => 1,
            ]);
            $user->settings()->create([]);
        } else {
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone_number' => $validated['phone_number'],
            ]);
        }

        // 2. Stripe Charge
        try {
            $stripeKey = config('services.stripe.secret') ?: (config('app.STRIPE_KEY') ?: env('STRIPE_KEY'));
            \Stripe\Stripe::setApiKey($stripeKey);

            if (empty($user->stripe_id)) {
                $customer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->first_name . ' ' . $user->last_name,
                ]);
                $user->stripe_id = $customer->id;
                $user->save();
            }

            $cust = \Stripe\Customer::retrieve($user->stripe_id);
            $amount = (int)$validated['custom_total_amount'];
            $chargeId = null;

            if (strpos($validated['stripe_token'], 'pm_') === 0) {
                // Attach the PaymentMethod to the Customer via HTTP
                \Illuminate\Support\Facades\Http::withToken($stripeKey)->asForm()->post("https://api.stripe.com/v1/payment_methods/{$validated['stripe_token']}/attach", [
                    'customer' => $cust->id
                ]);

                // Create a confirmed PaymentIntent via HTTP
                $response = \Illuminate\Support\Facades\Http::withToken($stripeKey)->asForm()->post("https://api.stripe.com/v1/payment_intents", [
                    'amount' => $amount,
                    'currency' => 'usd',
                    'customer' => $cust->id,
                    'payment_method' => $validated['stripe_token'],
                    'confirm' => 'true',
                    'off_session' => 'true',
                    'description' => $txDesc . " - California Target Book",
                ]);

                $resData = $response->json();

                if (!$response->successful() || ($resData['status'] ?? '') !== 'succeeded') {
                    $errorMsg = $resData['error']['message'] ?? 'Stripe payment failed.';
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                    ], 402);
                }
                $chargeId = $resData['latest_charge'] ?? $resData['id'];
            } else {
                $cust->source = $validated['stripe_token'];
                $cust->save();

                $charge = \Stripe\Charge::create([
                    'amount' => $amount,
                    'currency' => 'usd',
                    'customer' => $cust->id,
                    'description' => $txDesc . " - California Target Book",
                ]);

                if (!$charge->paid) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stripe payment failed. Please try again.',
                    ], 402);
                }
                $chargeId = $charge->id;
            }
        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            return response()->json([
                'success' => false,
                'message' => $body['error']['message'] ?? 'Stripe error occurred.',
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage(),
            ], 500);
        }

        // 3. Link to existing Subscription if it exists (no new Subscription created for book-only purchase)
        $subscription = $user->latestSubscription();
        $subscriptionId = $subscription ? $subscription->id : null;

        if ($subscriptionId) {
            $cycle = $subscription->cycles()->create([
                'payment_method' => 'stripe',
                'starts_on' => now()->toDateString(),
                'ends_on' => now()->addYears(1)->toDateString(),
                'invoice_id' => $chargeId,
            ]);
            $cycle->activate();
        }

        // Save transaction to local database
        try {
            $txAmount = $amount;
            // $txDesc is already defined at the top
            $txReceiptUrl = null;
            $txRaw = null;

            if (isset($charge) && $charge instanceof \Stripe\Charge) {
                $txReceiptUrl = $charge->receipt_url;
                $txRaw = $charge->jsonSerialize();
            } elseif (isset($resData) && is_array($resData)) {
                $txRaw = $resData;
                if (!empty($chargeId)) {
                    try {
                        $chObj = \Stripe\Charge::retrieve($chargeId);
                        $txReceiptUrl = $chObj->receipt_url;
                    } catch (\Exception $chEx) {}
                }
            }

            $txObj = \App\Transaction::create([
                'user_id' => $user->id,
                'subscription_id' => $subscriptionId,
                'stripe_charge_id' => $chargeId,
                'stripe_invoice_id' => null,
                'description' => $txDesc,
                'plan' => '—',
                'amount' => $txAmount,
                'status' => 'Completed',
                'payment_method' => 'stripe',
                'invoice_url' => $txReceiptUrl,
                'raw_stripe_data' => $txRaw,
                'transaction_date' => now(),
            ]);

            // Create DigitalAddonOrder records for purely digital add-ons
            $deck_types = $validated['deck_types'] ?? [];
            if (!empty($deck_types) && is_array($deck_types)) {
                foreach ($deck_types as $type) {
                    if ($type == config('subscriptions.deck_only')) {
                        \App\DigitalAddonOrder::create([
                            'user_id' => $user->id,
                            'transaction_id' => $txObj ? $txObj->id : null,
                            'item_name' => config('subscriptions.names.deck_only', 'Post-Election Deck Only') . ' (Subscriber)',
                            'amount' => config('subscriptions.deck_only') * 100,
                            'payment_status' => 'Paid',
                            'delivery_status' => 'Sent',
                        ]);
                    } elseif ($type == config('subscriptions.deck_presentation') . '_presentation') {
                        \App\DigitalAddonOrder::create([
                            'user_id' => $user->id,
                            'transaction_id' => $txObj ? $txObj->id : null,
                            'item_name' => config('subscriptions.names.deck_presentation', 'Post-Election Presentation') . ' (Subscriber)',
                            'amount' => config('subscriptions.deck_presentation') * 100,
                            'payment_status' => 'Paid',
                            'delivery_status' => 'Sent',
                        ]);
                    }
                }
            }
        } catch (\Exception $txEx) {
            Log::error("Failed to save transaction record in purchaseBookOnly: " . $txEx->getMessage());
        }

        // 4. Save Shipping Addresses & BookSubscriptions
        $deckAddresses = $validated['deck_addresses'] ?? [];
        foreach ($deckAddresses as $addr) {
            $address = \App\Address::create([
                'line1' => $addr['line1'] ?? '',
                'line2' => $addr['line2'] ?? null,
                'city' => $addr['city'] ?? '',
                'state' => $addr['state'] ?? '',
                'zip_code' => $addr['zip_code'] ?? '',
                'special_instructions' => $addr['special_instructions'] ?? null,
            ]);

            \App\BookSubscription::create([
                'subscription_id' => $subscriptionId,
                'user_id' => $user->id,
                'address_id' => $address->id,
                'item_name' => config('subscriptions.names.additional_printed_book', 'Additional Printed Book')
            ]);
        }

        // Log in the user if guest checks out
        if (!Auth::check()) {
            Auth::login($user);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your purchase!',
        ]);
    }

}
