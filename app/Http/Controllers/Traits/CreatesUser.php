<?php

namespace App\Http\Controllers\Traits;

use App\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Stripe;
use App\Subscription;
use App\User;
use App\Address;
use App\SubscriptionUser;
use App\Providers\GlobalsServiceProvider as Globals;
use App\Jobs\SendAddonInvitation;
use App\Jobs\SendInvoice;
Stripe\Stripe::setApiKey(config("app.STRIPE_KEY"));


/**
 * Creates user trait
 *  meant to be somewhat of an abstraction of creating
 *  a user between the normal registration and
 */

trait CreatesUser {

  static $create_user_admin_options = [
    'is_paid_for',
    'subscription_cost',
    'book_cost',
    'addon_cost',
  ];

  /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


  /**
   * Create a Validator for creating a user
   */
  public function create_user_validator($data, $override_rules = []) {

    return Validator::make(
      $data,
      /**
       * Default validation rules
       */
      array_merge([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone_number' => 'required|string',

        'company.name' => 'required|string|max:255',
        'company.address.line1' => 'required|string|max:255',
        'company.address.line2' => 'nullable|string|max:255',
        'company.address.city' => 'required|string|max:255',
        'company.address.state' => 'required|string|max:255',
        'company.address.zip_code' => 'required|string|max:255',

        // required if sub length is not a trial
        'payment_method' => 'required_unless:subscription_length,0|string',
        'stripe_token' => 'nullable|string|max:255',
        'subscription_length' => [
            'required',
            'numeric',
            Rule::in(Subscription::VALID_SUBSCRIPTION_LENGTHS),
        ],

        'book_addresses.*.line1' => 'required|string|max:255',
        'book_addresses.*.line2' => 'nullable|string|max:255',
        'book_addresses.*.city' => 'required|string|max:255',
        'book_addresses.*.state' => 'required|string|max:255',
        'book_addresses.*.zip_code' => 'required|string|max:255',
        'book_addresses.*.special_instructions' => 'nullable|string|max:255',

        'addons.*' => 'required|distinct|different:email|email|max:255',
      ], $override_rules),
      /**
       * Messages
       */
      [
          'payment_method.required' => 'Please select a payment method.',
          'subscription_length.required' => 'Please select your subscription length.',

          'company.address.line1.required' => 'This field is required.',
          'company.address.city.required' => 'This field is required.',
          'company.address.state.required' => 'This field is required.',
          'company.address.zip_code.required' => 'This field is required.',

          'book_addresses.*.line1.required' => 'This field is required.',
          'book_addresses.*.city.required' => 'This field is required.',
          'book_addresses.*.state.required' => 'This field is required.',
          'book_addresses.*.zip_code.required' => 'This field is required.',

          'addons.*.required' => 'Please fill in the addon email.',
          'addons.*.email' => 'Please fill in a valid e-mail address.',
          'addons.*.unique' => 'This email is already taken.',

          'stripe_token.string' => 'A payment method is required.',
      ]
    );
  }

/**
 * Create stripe customer
 */
  function createStripeCust($user)
  {
      $address = null;
      if (!empty($user['company']['address'])) {
          $addrData = $user['company']['address'];
          $state = ($addrData['state'] ?? '') === 'N/A' ? 'CA' : ($addrData['state'] ?? '');
          $zip = ($addrData['zip_code'] ?? '') === '00000' ? '95101' : ($addrData['zip_code'] ?? '');
          $city = ($addrData['city'] ?? '') === 'N/A' ? 'San Jose' : ($addrData['city'] ?? '');
          $line1 = ($addrData['line1'] ?? '') === 'Address Line 1' ? '123 Test Street' : ($addrData['line1'] ?? '');

          $address = [
              'line1' => $line1 ?: '123 Test Street',
              'line2' => $addrData['line2'] ?? '',
              'city' => $city ?: 'San Jose',
              'state' => $state ?: 'CA',
              'postal_code' => $zip ?: '95101',
              'country' => 'US',
          ];
      }

      $cust = \Stripe\Customer::create([
          'name' => $user['first_name'] . ' ' . $user['last_name'],
          'description' => $user['company']['name'] . ': ' . $user['first_name'] . ' ' . $user['last_name'],
          'email' => $user['email'],
          'address' => $address,
          'source' => $user['stripe_token']??null,
          'metadata' => [ 
              'payment_method' => $user['payment_method'],
              'ghl_contact_id' => $user['ghl_contact_id'] ?? null,
          ],
      ]);

      return $cust;
  }


  function updateUser(&$data){
    $user = User::where(['email' => $data['email']])->first();
    $userBody = [
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'phone_number' => $data['phone_number'],
    ];
    if (!empty($user)) {
        $baseUser = $user;
        $baseUser->update($userBody);
    }
  }
  /**
   * Creates a user and auxiliary records
   * This expects validation beforehand,
   *  The create_user_admin_options array should be used
   *  To exclude request fields by non admin
   */
  function createUser(&$data)
  {
      $isTrial = (int)$data['subscription_length'] === 0;
      $sub_emails = [];
      $user = User::where(['email' => $data['email']])->first();
      if(array_key_exists('register_by',$data)){
        $registerby = $data['register_by'];
      }
      else{
        $registerby = 'laravel';
      }
      if (empty($user) || empty($user->stripe_id)) {
          $cust = $this->createStripeCust($data);
        } else {
            try {
                $cust = \Stripe\Customer::retrieve($user->stripe_id);
                $cust->name = $data['first_name'] . ' ' . $data['last_name'];
                if (!empty($data['company']['address'])) {
                    $addrData = $data['company']['address'];
                    $state = ($addrData['state'] ?? '') === 'N/A' ? 'CA' : ($addrData['state'] ?? '');
                    $zip = ($addrData['zip_code'] ?? '') === '00000' ? '95101' : ($addrData['zip_code'] ?? '');
                    $city = ($addrData['city'] ?? '') === 'N/A' ? 'San Jose' : ($addrData['city'] ?? '');
                    $line1 = ($addrData['line1'] ?? '') === 'Address Line 1' ? '123 Test Street' : ($addrData['line1'] ?? '');

                    $cust->address = [
                        'line1' => $line1 ?: '123 Test Street',
                        'line2' => $addrData['line2'] ?? '',
                        'city' => $city ?: 'San Jose',
                        'state' => $state ?: 'CA',
                        'postal_code' => $zip ?: '95101',
                        'country' => 'US',
                    ];
                }
                if (!empty($data['stripe_token'])) {
                    $cust->source = $data['stripe_token'];
                }
                $cust->save();
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'No such customer') !== false) {
                    $cust = $this->createStripeCust($data);
                } else {
                    throw $e;
                }
            }
        }

        $company = Company::where([ 'name' => $data['company']['name'] ])->first();
        if (empty($company)) {
            $company_address = Address::create($data['company']['address']);
            $company = Company::create([
                'name' => $data['company']['name'],
                'address_id' => $company_address->id,
            ]);
        }


    /**
     * Persist new user
     */
    $userBody = [
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'password' => !empty($data['password']) ? bcrypt($data['password']) : null,
        'email_token' => base64_encode($data['email']),
        'stripe_id' => $cust['id'],
        'company_id' => $company->id,
        'register_by' => $registerby,
    ];
    if (empty($user)) {
        $baseUser = User::create($userBody);
    } else {
        $baseUser = $user;
        $baseUser->update($userBody);
    }
    // Initialize user settings
    $baseUser->settings()->create([]);

    /**
     * Create Subscription record
     */
    $frequency = (int)($data['subscription_length'] ?? 0);
    $calculatedDate = now()->addMonths($frequency == 0 ? 0 : $frequency)->toDateString();
    if ($frequency == 0) {
        $calculatedDate = now()->addDays(7)->toDateString();
    }

    $subscription = Subscription::make([
        'account_id' => $baseUser->id,
        'frequency' => $frequency,
        'next_payment' => $data['next_payment'] ?? $calculatedDate,
        'end_date' => $data['end_date'] ?? $calculatedDate,
        'status' => $data['status'] ?? 'active',
        'wordpress_subscription_id' => $data['wordpress_subscription_id'] ?? null,
    ]);
    $baseUser->subscriptions()->save($subscription, ['role' => SubscriptionUser::SUBSCRIBER]);

    $cycle = $subscription->cycles()->create([
        'payment_method' => $data['payment_method'],
    ]);

    /**
     * Add base subscription to user invoice in stripe
     */
    if ($isTrial) {
        $base_cost = 0;
        $subTitle = "7 Day Trial";
        $data['is_paid_for'] = true;
        $data['send_invoice'] = false;
    } else if ($subscription->frequency === 12) {
        $base_cost = Globals::SUBSCRIPTION_COST_1YR;
        $subTitle = "12 Month";
    } else {
        $base_cost = Globals::SUBSCRIPTION_COST_2YR;
        $subTitle = "24 Month";
    }
    if (array_key_exists('subscription_cost',$data) && is_numeric($data['subscription_cost'])) {
        $base_cost = $data['subscription_cost'];
    }
    if ($cycle->payment_method !== 'stripe') {
        $baseUser->addInvoiceItem([
            'amount' => $base_cost,
            'description' => "$subTitle Online Subscription to The California Target Book",
            'metadata' => [ 'cycle_id' => $cycle->id ],
        ]);
    }

    /**
     * Create book subscriptions from addresses
     */
    $addresses = collect($data['book_addresses']??[]);

    $book_subs = $addresses->map(function ($addr) use ($subscription) {
        $address = Address::create($addr);
        $book_sub = $subscription->book_subscriptions()
        ->create([ 'address_id' => $address->id ]);

        $book_sub->address = $address;
        return $book_sub;
    });


    if (array_key_exists('book_cost',$data) && is_numeric($data['book_cost'])) {
        $book_cost = $data['book_cost'];
    } else {
        $book_cost = Globals::getBookSubscriptionPrice($subscription->frequency);
    }
    if ($cycle->payment_method !== 'stripe') {
        $book_subs->each(function ($bs) use ($baseUser, $subscription, $subTitle, $book_cost) {
            $addr_line1 = $bs->address->line1;
            $baseUser->addInvoiceItem([
                'amount' => $book_cost,
                'description' => "$subTitle Hard Copy Subscription to $addr_line1",
            ]);
        });
    }


    /**
     * Create add on accounts
     */
    $addons = collect($data['addons']??[])
        ->map(function ($addonEmail) use ($subscription, $company, $data, $registerby) {
            $existing = User::where(['email' => $addonEmail])->first();
            $addonBody = [
                'email' => $addonEmail,
                'email_token' => base64_encode($addonEmail),
                'company_id' => $company->id,
                'register_by' => $registerby,
            ];
            if (empty($existing)) {
                $addon = User::make();
            } else {
                $addon = $existing;
            }
            $sub_emails[] = array(
                'email'=>$addon->email,
                'api_token'=>$addon->api_token,
            );
            $addon->fill($addonBody);

            return $subscription->users()
                ->save($addon, ['role' => SubscriptionUser::ADDON]);
        });

    if (is_numeric($data['addon_cost']??[])) {
        $addon_cost = $data['addon_cost'];
    } else {
        $addon_cost = Globals::ADDON_COST;
    }
    if ($cycle->payment_method !== 'stripe') {
        $addons->each(function ($addon) use ($baseUser, $subscription, $subTitle, $addon_cost) {
            $baseUser->addInvoiceItem([
                'amount' => $addon_cost,
                'description' => "$subTitle Online Subscription Addon Account, for $addon->email",
            ]);
        });
    }

    /**
     * Issue stripe invoice or subscription
     */
    if (array_key_exists('is_paid_for',$data) && $data['is_paid_for']) {
        // If marked paid manually (e.g. Paying by Check, or check is paid up manually)
        $invoice = $baseUser->createInvoice([
            'description' => 'California Target Book Online Subscription',
            'metadata' => [
                'cycle_id' => $cycle->id,
                'subscription_id' => $subscription->id,
            ]
        ]);
        $cycle->invoice_id = $invoice->id;
        $cycle->save();
    } else if ($cycle->payment_method === 'stripe') {
        try {
            // Calculate total amount based on actual count of books and addons
            $total_amount = $base_cost + (($book_cost ?? 0) * $book_subs->count()) + (($addon_cost ?? 0) * $addons->count());
            // Step 1: Create a Plan in Stripe (Highly compatible with older SDK versions)
            $frequency = (int)$subscription->frequency;
            $interval = 'month';
            $interval_count = $frequency;
            if ($frequency === 12) {
                $interval = 'year';
                $interval_count = 1;
            } else if ($frequency === 24) {
                $interval = 'year';
                $interval_count = 2;
            } else if ($frequency === 0) {
                $interval = 'day';
                $interval_count = 7; // Trial
            }

            $stripePlan = \Stripe\Plan::create([
                'amount' => $total_amount, // already in cents
                'currency' => 'usd',
                'interval' => $interval,
                'interval_count' => $interval_count,
                'product' => [
                    'name' => 'California Target Book Online Subscription',
                ],
                'id' => 'plan_' . uniqid() . '_' . $frequency . 'm',
            ]);

            // Step 2: Create the Stripe Subscription using the Plan inside items array
            $stripeSubParams = [
                'customer' => $cust->id,
                'items' => [
                    ['plan' => $stripePlan->id],
                ],
                'default_source' => $cust->default_source ?? null,
                'metadata' => [
                    'cycle_id' => $cycle->id,
                    'subscription_id' => $subscription->id,
                ],
            ];
            
            // Handle 7-day trial if frequency is 0
            if ($frequency === 0) {
                $stripeSubParams['trial_end'] = now()->addDays(7)->timestamp;
            }

            $stripeSub = \Stripe\Subscription::create($stripeSubParams);

            // Fetch the first invoice of this subscription
            $latestInvoiceId = $stripeSub->latest_invoice;
            $invoice = \Stripe\Invoice::retrieve($latestInvoiceId);
            
            // Pay the invoice immediately so the subscription becomes active
            try {
                $invoice->pay();
                // Refresh the invoice and subscription status
                $invoice = \Stripe\Invoice::retrieve($latestInvoiceId);
                $stripeSub = \Stripe\Subscription::retrieve($stripeSub->id);
            } catch (\Exception $payException) {
                \Illuminate\Support\Facades\Log::warning('Stripe Subscription immediate payment failed: ' . $payException->getMessage());
            }
            
            $cycle->invoice_id = $latestInvoiceId;
            $cycle->save();

            // Link the Stripe subscription ID to our subscription record
            $subscription->wordpress_subscription_id = $stripeSub->id;
            if (isset($stripeSub->current_period_end)) {
                $periodEnd = date('Y-m-d', $stripeSub->current_period_end);
                $subscription->next_payment = $periodEnd;
                $subscription->end_date = $periodEnd;
            }
            $subscription->save();

            \Illuminate\Support\Facades\Log::info('Stripe Subscription successfully created in Stripe:', [
                'stripe_sub_id' => $stripeSub->id,
                'customer_id'   => $cust->id,
                'email'         => $baseUser->email,
            ]);

            $data['is_paid_for'] = ($stripeSub->status === 'active' || $stripeSub->status === 'trialing' || $invoice->paid);

        } catch (\Stripe\Error\Base $e) {
            if (isset($invoice)) {
                $this->cancelCreate($baseUser, $invoice);
            }
            return $this->handle_stripe_error($e);
        }
    }

    if (isset($invoice) && isset($data['send_invoice']) && $data['send_invoice']) {
        dispatch(new SendInvoice($baseUser, $invoice));
    }

    if (array_key_exists('is_paid_for',$data) && $data['is_paid_for']) {
      $cycle->activate();

      // GoHighLevel synchronization for paid subscription
      try {
          if (class_exists('\App\Services\GHLPaymentService')) {
              $ghlService = new \App\Services\GHLPaymentService();
              $ghlService->syncSubscriptionToLaravel($baseUser, $subscription, $data);
          }
      } catch (\Exception $e) {
          \Illuminate\Support\Facades\Log::error('GHL Sync Failed in createUser flow: ' . $e->getMessage(), [
              'user_id' => $baseUser->id,
              'exception' => $e
          ]);
      }
    }
    $baseUser['addons'] = $addons;
    return $baseUser;
  }

  public function createUserAndSubscription($data)
  {
      $user = User::where(['email' => $data['email']])->first();
      
      if(array_key_exists('register_by',$data)){
        $registerby = $data['register_by'];
      }
      else{
        $registerby = 'laravel';
      }

      try {
          if (empty($user) || empty($user->stripe_id)) {
              $cust = $this->createStripeCust($data);
            } else {
                try {
                    $cust = \Stripe\Customer::retrieve($user->stripe_id);
                    $cust->name = $data['first_name'] . ' ' . $data['last_name'];
                    if (!empty($data['company']['address'])) {
                        $addrData = $data['company']['address'];
                        $state = ($addrData['state'] ?? '') === 'N/A' ? 'CA' : ($addrData['state'] ?? '');
                        $zip = ($addrData['zip_code'] ?? '') === '00000' ? '95101' : ($addrData['zip_code'] ?? '');
                        $city = ($addrData['city'] ?? '') === 'N/A' ? 'San Jose' : ($addrData['city'] ?? '');
                        $line1 = ($addrData['line1'] ?? '') === 'Address Line 1' ? '123 Test Street' : ($addrData['line1'] ?? '');

                        $cust->address = [
                            'line1' => $line1 ?: '123 Test Street',
                            'line2' => $addrData['line2'] ?? '',
                            'city' => $city ?: 'San Jose',
                            'state' => $state ?: 'CA',
                            'postal_code' => $zip ?: '95101',
                            'country' => 'US',
                        ];
                    }
                    if (!empty($data['stripe_token'])) {
                        $cust->source = $data['stripe_token'];
                    }
                    $cust->save();
                } catch (\Exception $e) {
                    if (strpos($e->getMessage(), 'No such customer') !== false) {
                        $cust = $this->createStripeCust($data);
                    } else {
                        throw $e;
                    }
                }
            }
      } catch (\Exception $e) {
          throw $e;
      }

        $company = Company::where([ 'name' => $data['company']['name'] ])->first();
        if (empty($company)) {
            $company_address = Address::create($data['company']['address']);
            $company = Company::create([
                'name' => $data['company']['name'],
                'address_id' => $company_address->id,
            ]);
        }


    /**
     * Persist new user
     */
    $plainPassword = $data['password'] ?? null;
    $isNewUser = empty($user);

    if ($isNewUser && empty($plainPassword)) {
        $plainPassword = \Illuminate\Support\Str::random(10);
    }

    $userBody = [
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'email_token' => base64_encode($data['email']),
        'stripe_id' => $cust['id'],
        'company_id' => $company->id,
        'register_by' => $registerby,
    ];

    if (!empty($plainPassword)) {
        $userBody['password'] = bcrypt($plainPassword);
    }

    try {
        if ($isNewUser) {
            $baseUser = User::create($userBody);

            // Send Credentials Email
            $this->sendCredentialsEmail($baseUser, $plainPassword);
        } else {
            $baseUser = $user;
            $baseUser->update($userBody);
        }
        
        // Initialize user settings
        $baseUser->settings()->create([]);
    } catch (\Exception $e) {
        throw $e;
    }

    // Call GHL API for order details
    if (!empty($data['contact_id'])) {
        $contactId  = $data['contact_id'];
        $ghlToken   = config('app.GHL_TOKEN') ?? 'pit-9edbcb56-3ea3-4e72-b633-a54a943ec8cf';
        $locationId = 'Fvvh7SvvoDgMQg4PNPCB';


        try {
            // Step 1: Fetch orders list (confirmed: data lives under "data" key)
            $ordersResponse = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => "Bearer $ghlToken",
                'Version'       => '2021-07-28',
                'Accept'        => 'application/json',
            ])->get('https://services.leadconnectorhq.com/payments/orders/', [
                'altId'     => $locationId,
                'altType'   => 'location',
                'contactId' => $contactId,
            ]);

            if ($ordersResponse->successful()) {
                // Orders are under the "data" key
                $orders = $ordersResponse->json('data', []);

                if (!empty($orders)) {
                    // Get the most recently created order
                    $latestOrder = collect($orders)->sortByDesc('createdAt')->first();
                    $orderId     = $latestOrder['_id'] ?? $latestOrder['id'] ?? null;

                    if ($orderId) {
                        // Step 2: Fetch order detail (confirmed: items at root level, no "data" wrapper)
                        $orderDetailResponse = \Illuminate\Support\Facades\Http::withHeaders([
                            'Authorization' => "Bearer $ghlToken",
                            'Version'       => '2021-07-28',
                            'Accept'        => 'application/json',
                        ])->get("https://services.leadconnectorhq.com/payments/orders/{$orderId}", [
                            'altId'   => $locationId,
                            'altType' => 'location',
                        ]);

                        if ($orderDetailResponse->successful()) {
                            // Order detail returns the object at root level
                            // items[] is directly on the root, NOT under a "data" key
                            $orderDetail = $orderDetailResponse->json();
                            $items       = $orderDetail['items'] ?? [];

                            // Check item.name (variant) first, then item.product.name (base product)
                            $nameToCheck = $items[0]['name'] ?? $items[0]['product']['name'] ?? null;

                            if ($nameToCheck) {
                                if (stripos($nameToCheck, 'Subscription') === false) {
                                    return $baseUser;
                                }

                                if (stripos($nameToCheck, 'CTB One') !== false || stripos($nameToCheck, '12 Month') !== false) {
                                    $data['subscription_length'] = 12;
                                } elseif (stripos($nameToCheck, 'CTB Two') !== false || stripos($nameToCheck, '24 Month') !== false) {
                                    $data['subscription_length'] = 24;
                                } elseif (stripos($nameToCheck, 'Trial') !== false) {
                                    $data['subscription_length'] = 0;
                                }
                            }
                        } 
                    }
                }
            } 
        } catch (\Exception $e) {
            // Silently fail — subscription length keeps its original value
        }
    } 
    
    try {
        $frequency = (int)($data['subscription_length'] ?? 0);
        $date = now()->addMonths($frequency == 0 ? 0 : $frequency)->toDateString();
        if ($frequency == 0) $date = now()->addDays(7)->toDateString();
        
        $subscription = Subscription::make([
            'account_id' => $baseUser->id,
            'frequency' => $frequency,
            'next_payment' => $date,
            'end_date' => $date,
            'status' => $data['status'] ?? 'active',
            'wordpress_subscription_id' => $data['wordpress_subscription_id'] ?? null,
        ]);
        $baseUser->subscriptions()->save($subscription, ['role' => SubscriptionUser::SUBSCRIBER]);

        $cycle = $subscription->cycles()->create([
            'payment_method' => $data['payment_method'] ?? 'stripe',
        ]);

        if (array_key_exists('is_paid_for',$data) && $data['is_paid_for']) {
          $cycle->activate();
        }
    } catch (\Exception $e) {
        throw $e;
    }

    /**
     * For CTB One (12-month) subscriptions, fetch the GHL subscription ID
     * and link it to the Laravel subscription record.
     */
    if ($frequency === 12 && !empty($data['contact_id'])) {
        try {
            $contactId  = $data['contact_id'];
            $ghlToken   = config('app.GHL_TOKEN') ?? 'pit-9edbcb56-3ea3-4e72-b633-a54a943ec8cf';
            $locationId = 'Fvvh7SvvoDgMQg4PNPCB';

            $subscriptionsResponse = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => "Bearer $ghlToken",
                'Version'       => '2021-07-28',
                'Accept'        => 'application/json',
            ])->get('https://services.leadconnectorhq.com/payments/subscriptions/', [
                'altId'     => $locationId,
                'altType'   => 'location',
                'contactId' => $contactId,
            ]);

            if ($subscriptionsResponse->successful()) {
                $ghlSubscriptions = $subscriptionsResponse->json('data', []);

                if (!empty($ghlSubscriptions)) {
                    // Get the most recently created GHL subscription
                    $latestGhlSub = collect($ghlSubscriptions)->sortByDesc('createdAt')->first();
                    $ghlSubId     = $latestGhlSub['_id'] ?? $latestGhlSub['id'] ?? null;

                    if ($ghlSubId) {
                        $subscription->wordpress_subscription_id = $ghlSubId;
                        $subscription->save();

                        \Illuminate\Support\Facades\Log::info('GHL subscription ID linked', [
                            'user_id'             => $baseUser->id,
                            'subscription_id'     => $subscription->id,
                            'ghl_subscription_id' => $ghlSubId,
                        ]);
                    }
                }
            } else {
                \Illuminate\Support\Facades\Log::warning('GHL subscriptions API failed', [
                    'status' => $subscriptionsResponse->status(),
                    'body'   => $subscriptionsResponse->body(),
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('GHL subscriptions API error', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    return $baseUser;
  }
  //update subscription status using API
  public function updateSubscriptionStatus($subscription_id,$status,$next_payment_date,$end_date){
    $subscription = Subscription::where('wordpress_subscription_id', $subscription_id)->first();

    // Check if the subscription exists
    if ($subscription) {
        // Update the status of the subscription
        $sub_id = $subscription->id;
        if($next_payment_date != '' || $end_date != ''){
            $cycle = $subscription->getLatestCycle();
        }

        if($next_payment_date != '' && $next_payment_date != '0'){
            $data = array('ends_on'=>$next_payment_date);
            $cycle->update($data);
        }
        else{
            if($end_date != ''){
                $data = array('ends_on'=>$end_date);
                $cycle->update($data);
            }
        }
        $subscription->status = $status;
        $subscription->save();
        // Optionally, you can return the updated subscription object
        return $subscription;
    } else {
        // Subscription not found
        return null;
    }
  }


  // Delete user and all related items
  public function cancelCreate($user, $invoice) {
      $invoice->closed = true;
      $invoice->save();

    $sub = $user->subscriptions()->first();
    if ($sub) {
        $cycle = $sub->cycles()->first();

        // delete stripe invoice
        if ($cycle) {
            $in = \Stripe\Invoice::retrieve($cycle->invoice_id);
            $in->closed = true;
            $in->save();
            $cycle->delete();
        }

        $sub->book_subscriptions()->delete();

        $users = $sub->users();
        $users->detach();

        $sub->delete();
    }
  }
  public function deleteuseapi($user){
    $sub = $user->subscriptions()->first();
    $type = 'addon';
    $emailArray = [];
    if ($sub) {
        $subusers = $sub->addons;
        if(!empty($subusers)){
            foreach ($subusers as $inuser) {
                $email = $inuser->email;
                $emailArray[] = $email;
            }
        }
        $type = $sub->getOriginal('pivot_role');
        if($type == 'subscriber'){
            $cycle = $sub->cycles()->first();

            // delete stripe invoice
            if ($cycle) {
                $cycle->delete();
            }

            $sub->book_subscriptions()->delete();
            $users = $sub->users();
            $users->detach();
            $sub->delete();
        }
    }
    $user->delete();
    $data = array(
        'type'=>$type,
        'users'=>$emailArray,
    );
    return $data;
  }
  private function handle_stripe_error($e) {
    $body = $e->getJsonBody();
    $req = request();
    if ($req->expectsJson()) {
        $res = response()
            ->json([ 'errors' => [ 'stripe_token' => [$body['error']['message']] ] ], 422);
    } else {
        $res = back()
            ->withInput()
            ->withErrors([ 'stripe_token' => [$body['error']['message']] ]);
    }
    throw new HttpResponseException($res);
  }

  /**
   * Send credentials email to the user
   */
  protected function sendCredentialsEmail($user, $password)
  {
      if (empty($password)) {
          return;
      }

      try {
          \Illuminate\Support\Facades\Mail::send('email.credentials', ['user' => $user, 'password' => $password], function ($message) use ($user) {
              $message->to($user->email, $user->first_name . ' ' . $user->last_name)
                      ->subject('Your Account Credentials for California Target Book');
          });
      } catch (\Exception $e) {
      }
  }

}
