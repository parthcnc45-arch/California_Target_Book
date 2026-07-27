<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Http\Controllers\Controller;
use App\Providers\GlobalsServiceProvider as Globals;
use App\BookSubscription;
use App\User;
use App\Address;
use App\Subscription;
use App\SubscriptionUser;
use App\Jobs\SendInvoice;
use function Sodium\add;
use Stripe\Stripe;

class AccountController extends Controller
{
    private function getAccountData() {
        $user = Auth::user();

        // Fetch purchased add-ons (digital and physical)
        $digitalAddons = \App\DigitalAddonOrder::where('user_id', $user->id)
            ->get()
            ->map(function($order) {
                return [
                    'name' => str_replace(' (Subscriber)', '', str_replace(' (Non-Subscriber)', '', $order->item_name)),
                    'type' => 'Digital',
                    'price' => '$' . number_format($order->amount / 100, 2),
                    'date' => $order->created_at ? $order->created_at->format('M j, Y') : '-',
                    'status' => $order->payment_status ?? 'Paid',
                    'status_class' => 'badge-team-active'
                ];
            });

        $bookAddons = \App\BookSubscription::where('user_id', $user->id)
            ->where(function($query) {
                $query->where('item_name', 'LIKE', '%Additional%Printed Book%')
                      ->orWhere('item_name', 'LIKE', '%Additionaly%Printed Book%');
            })
            ->get()
            ->map(function($book) {
                $priceVal = config('subscriptions.additional_printed_book') ?? 150;
                $status = strtolower($book->status ?? 'processing');
                $statusClass = 'badge-team-pending';
                if ($status === 'delivered') {
                    $statusClass = 'badge-team-active';
                }
                return [
                    'name' => str_replace(' (Subscriber)', '', str_replace(' (Non-Subscriber)', '', $book->item_name)),
                    'type' => 'Physical',
                    'price' => '$' . number_format($priceVal, 2),
                    'date' => $book->created_at ? $book->created_at->format('M j, Y') : '-',
                    'status' => ucfirst($book->status ?? 'Processing'),
                    'status_class' => $statusClass
                ];
            });

        $purchasedAddons = $digitalAddons->concat($bookAddons);

        $user->load('company.address');
        $sub = $user->latestSubscription();

        if (empty($sub)) {
            $prevSub = $user->subscriptions()->first();
            $directBooks = \App\BookSubscription::where('user_id', $user->id)->with('address')->get();
            if ($directBooks->isNotEmpty()) {
                return [
                    'user' => $user,
                    'pending_bank' => null,
                    'cycles' => collect(),
                    'purchasedAddons' => $purchasedAddons,
                    'sub' => [
                        'cycle' => null,
                        'status' => 'None',
                        'end' => null,
                        'start' => null,
                        'base_account' => $user,
                        'role' => 'owner',
                        'addons' => collect(),
                        'books' => $directBooks,
                        'invoice' => null,
                    ]
                ];
            }
            if (empty($prevSub)) {
                return [
                    'user' => $user,
                    'pending_bank' => null,
                    'cycles' => collect(),
                    'purchasedAddons' => $purchasedAddons,
                    'sub' => [
                        'cycle' => null,
                        'status' => 'None',
                        'end' => null,
                        'start' => null,
                        'base_account' => $user,
                        'role' => 'owner',
                        'addons' => collect(),
                        'books' => collect(),
                        'invoice' => null,
                    ]
                ];
            } else {
                return 'renew';
            }
        }

        $base_account = $user === $sub->account_id ? $user : User::find($sub->account_id);
        $currentCycle = $sub->getCurrentCycle();
        $latestCycle = $sub->getLatestCycle();

        // Can't find invoice
        try {
            $invoice = ($currentCycle && $currentCycle->invoice_id) ? \Stripe\Invoice::retrieve($currentCycle->invoice_id) : null;
        } catch (\Exception $e) {
            $invoice = null;
        }

        $ba = '';
        if (!empty($user->stripe_id)) {
            try {
                $cust = \Stripe\Customer::retrieve($user->stripe_id);
                if ($cust->sources && isset($cust->sources->data[0])) {
                    $bank_account = $cust->sources->data[0];
                    if (property_exists($bank_account, 'status') && $bank_account->status === 'new') {
                        $ba = $bank_account;
                    }
                }
            } catch (\Exception $e) {
                \Log::warning("Stripe Customer Retrieve Failed for user {$user->id}: " . $e->getMessage());
                $ba = '';
            }
        }

        $cycles = $sub ? $sub->cycles()->orderBy('starts_on', 'desc')->get() : collect();

        $stripe_subscription = null;
        $stripe_product_name = null;
        if ($sub && !empty($sub->wordpress_subscription_id) && strpos($sub->wordpress_subscription_id, 'sub_') === 0) {
            try {
                \Stripe\Stripe::setApiKey(config('app.STRIPE_KEY'));
                $stripe_subscription = \Stripe\Subscription::retrieve($sub->wordpress_subscription_id);
                
                if (!empty($stripe_subscription->plan->product)) {
                    $product = \Stripe\Product::retrieve($stripe_subscription->plan->product);
                    $stripe_product_name = $product->name;
                } elseif (!empty($stripe_subscription->items->data[0]->plan->product)) {
                    $product = \Stripe\Product::retrieve($stripe_subscription->items->data[0]->plan->product);
                    $stripe_product_name = $product->name;
                }
            } catch (\Exception $e) {
                \Log::warning("Could not retrieve Stripe subscription for user {$user->id}: " . $e->getMessage());
            }
        }

        $books = $sub->load('book_subscriptions.address')->book_subscriptions;
        $directBooks = \App\BookSubscription::where('user_id', $user->id)->with('address')->get();
        $mergedBooks = $books->merge($directBooks)->unique('id')->values();

        return [
            'user' => $user,
            'pending_bank' => $ba,
            'cycles' => $cycles,
            'purchasedAddons' => $purchasedAddons,
            'sub' => [
                'cycle' => $currentCycle,
                'status' => $sub->status(),
                'end' => ($latestCycle && $latestCycle->ends_on) ? (new Carbon($latestCycle->ends_on))->toFormattedDateString() : null,
                'start' => ($currentCycle && $currentCycle->starts_on) ? (new Carbon($currentCycle->starts_on))->toFormattedDateString() : null,
                'base_account' => $base_account,
                'role' => $sub->pivot->role,
                'addons' => $sub->addons()->get(),
                'books' => $mergedBooks,
                'invoice' => $invoice,
                'stripe_data' => $stripe_subscription,
                'stripe_product_name' => $stripe_product_name,
            ]
        ];
    }

    public function index() {
        return redirect()->route('auth.account.info');
    }

    public function accountInfo() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.account_info', $data);
    }

    public function subscriptions() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.subscriptions', $data);
    }

    public function manageAddOns() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.manage_add_ons', $data);
    }

    public function addonCheckout(\Illuminate\Http\Request $request) {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }

        $addonType = $request->input('addon', 'deck'); // 'deck' or 'presentation'
        
        if ($addonType === 'presentation') {
            $data['addonTitle'] = 'Post-Election Deck Presentation';
            $data['addonPrice'] = config('subscriptions.deck_presentation');
        } else {
            $data['addonTitle'] = 'Post-Election Deck';
            $data['addonPrice'] = config('subscriptions.deck_only');
        }
        $data['addonType'] = $addonType;

        return view('auth.account.addon_checkout', $data);
    }

    public function processAddonCheckout(\Illuminate\Http\Request $request) {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'stripe_token' => 'required|string',
            'qty' => 'required|integer|min:1',
            'addon_price' => 'required|numeric',
            'addon_name' => 'required|string',
            'addresses' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $qty = (int) $request->input('qty');
        $addonPrice = (float) $request->input('addon_price');
        $amount = $qty * $addonPrice * 100; // in cents
        $stripe_token = $request->input('stripe_token');

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
            $cust->source = $stripe_token;
            $cust->save();

            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'customer' => $cust->id,
                'description' => "Purchase of {$qty}x " . $request->input('addon_name') . " - California Target Book",
            ]);

            if ($charge->paid) {
                $sub = $user->latestSubscription();
                
                // Save transaction to local database first so we can link it
                $txObj = null;
                try {
                    $txObj = \App\Transaction::create([
                        'user_id' => $user->id,
                        'subscription_id' => $sub ? $sub->id : null,
                        'stripe_charge_id' => $charge->id ?? null,
                        'stripe_invoice_id' => null,
                        'description' => "Purchase of {$qty}x " . $request->input('addon_name') . " - California Target Book",
                        'plan' => 'Add-on - One-Time',
                        'amount' => $amount,
                        'status' => 'Completed',
                        'payment_method' => 'stripe',
                        'invoice_url' => $charge->receipt_url ?? null,
                        'raw_stripe_data' => isset($charge) ? $charge->jsonSerialize() : null,
                        'transaction_date' => now(),
                    ]);
                } catch (\Exception $txEx) {
                    \Log::error("Failed to save transaction record in processAddonCheckout: " . $txEx->getMessage());
                }

                $addonName = $request->input('addon_name');
                $isDigital = (stripos($addonName, 'Deck') !== false || stripos($addonName, 'Presentation') !== false);

                if ($isDigital) {
                    // Create DigitalAddonOrder
                    \App\DigitalAddonOrder::create([
                        'user_id' => $user->id,
                        'transaction_id' => $txObj ? $txObj->id : null,
                        'item_name' => $addonName,
                        'amount' => $amount,
                        'payment_status' => 'Paid',
                        'delivery_status' => 'Sent',
                    ]);
                } elseif ($sub) {
                    $addresses = $request->input('addresses', []);
                    foreach ($addresses as $addrData) {
                        $address = \App\Address::create([
                            'line1' => $addrData['line1'] ?? '',
                            'line2' => $addrData['line2'] ?? null,
                            'city' => $addrData['city'] ?? '',
                            'state' => $addrData['state'] ?? '',
                            'zip_code' => $addrData['zip_code'] ?? '',
                            'special_instructions' => $addrData['special_instructions'] ?? null,
                        ]);

                        \App\BookSubscription::create([
                            'subscription_id' => $sub->id,
                            'user_id' => $user->id,
                            'address_id' => $address->id,
                            'item_name' => $addonName
                        ]);
                    }
                }

                \Log::info("User {$user->id} purchased {$qty}x " . $request->input('addon_name') . " for $" . ($amount/100));

                $request->session()->flash('message', 'Payment processed successfully!');

                return response()->json([
                    'success' => true,
                    'message' => 'Payment processed successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment was not successful. Please try again.',
                ], 402);
            }
        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            return response()->json([
                'success' => false,
                'message' => $body['error']['message'] ?? 'Stripe error occurred.',
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Addon Purchase Failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function transactionHistory() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }

        $user = Auth::user();
        $dbTransactions = \App\Transaction::where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        $dbTransactions->through(function ($t) {
            $dateFormatted = $t->transaction_date 
                ? $t->transaction_date->format('F j, Y') 
                : $t->created_at->format('F j, Y');
                
            $timestamp = $t->transaction_date 
                ? $t->transaction_date->timestamp 
                : $t->created_at->timestamp;

            $displayPlan = $t->plan ?? '—';
            if ($displayPlan === 'One-Year') {
                $displayPlan = 'Subscription - 1 Year';
            } elseif ($displayPlan === 'Two-Year') {
                $displayPlan = 'Subscription - 2 Year';
            } elseif ($displayPlan === '—' || empty($displayPlan)) {
                $descLower = strtolower($t->description);
                if (str_contains($descLower, 'user seat')) {
                    $displayPlan = 'Seat - Yearly';
                } elseif (str_contains($descLower, 'deck') || str_contains($descLower, 'presentation') || str_contains($descLower, 'book')) {
                    $displayPlan = 'Add-on - One-Time';
                }
            }

            return (object)[
                'date' => $dateFormatted,
                'timestamp' => $timestamp,
                'description' => $t->description,
                'plan' => $displayPlan,
                'amount' => '$' . number_format($t->amount / 100, 2),
                'status' => $t->status,
                'invoice_url' => $t->invoice_url,
            ];
        });

        $data['transactions'] = $dbTransactions;

        return view('auth.account.transaction_history', $data);
    }

    public function viewInvoice($invoice_id) {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }

        $user = Auth::user();

        try {
            $stripeKey = config('services.stripe.secret') ?: (config('app.STRIPE_KEY') ?: env('STRIPE_KEY'));
            \Stripe\Stripe::setApiKey($stripeKey);
            $invoice = \Stripe\Invoice::retrieve($invoice_id);

            // Check Authorization
            $authorized = false;
            if ($invoice->customer === $user->stripe_id || $invoice->customer_email === $user->email) {
                $authorized = true;
            } else {
                // Check if any cycle of user's subscriptions contains this invoice ID
                $sub = $user->latestSubscription();
                if ($sub) {
                    $authorized = $sub->cycles()->where('invoice_id', $invoice_id)->exists();
                }
            }
            
            if (!$authorized) {
                abort(403, 'Unauthorized.');
            }
            
            $data['invoice'] = $invoice;
            $data['sub']['invoice'] = null; // Prevent layouts/portal from calling json_encode on Stripe object (PHP 8.2 crash)
            return view('auth.account.invoice', $data);
            
        } catch (\Exception $e) {
            \Log::error("Invoice retrieval failed for {$invoice_id}: " . $e->getMessage());
            abort(404, 'Invoice not found.');
        }
    }

    public function shippingTracking() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.shipping_tracking', $data);
    }

    public function notificationSettings() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.notification_settings', $data);
    }

    public function helpSupport() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.help_support', $data);
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();
        if (!$user) {
            $token = $request->bearerToken() ?: $request->input('api_token');
            if ($token) {
                $user = User::where('api_token', $token)->first();
            }
        }
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:50',
            'companyName' => 'required|string|max:255',
            
            // Billing Address
            'billing.line1' => 'required|string|max:255',
            'billing.line2' => 'nullable|string|max:255',
            'billing.city' => 'required|string|max:255',
            'billing.state' => 'required|string|max:2',
            'billing.zip_code' => 'required|string|max:20',
            'billing.special_instructions' => 'nullable|string|max:255',

            // Shipping Addresses
            'shippings.*.line1' => 'required_unless:shippings.*.sameAsBilling,true|nullable|string|max:255',
            'shippings.*.line2' => 'nullable|string|max:255',
            'shippings.*.city' => 'required_unless:shippings.*.sameAsBilling,true|nullable|string|max:255',
            'shippings.*.state' => 'required_unless:shippings.*.sameAsBilling,true|nullable|string|max:2',
            'shippings.*.zip_code' => 'required_unless:shippings.*.sameAsBilling,true|nullable|string|max:20',
            'shippings.*.special_instructions' => 'nullable|string|max:255',
        ]);

        $validator->validate();

        // 1. Update User
        $parts = explode(' ', $data['fullName'], 2);
        $user->first_name = $parts[0];
        $user->last_name = isset($parts[1]) ? $parts[1] : '';
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->save();

        // 2. Update Company
        $company = $user->company;
        if (!$company) {
            $company = new \App\Company();
            $company->name = $data['companyName'];
            $company->save();
            $user->company_id = $company->id;
            $user->save();
        } else {
            $company->name = $data['companyName'];
            $company->save();
        }

        // 3. Update Billing Address
        $billingAddr = $company->address;
        if (!$billingAddr) {
            $billingAddr = \App\Address::create($data['billing']);
            $company->address_id = $billingAddr->id;
            $company->save();
        } else {
            $billingAddr->update($data['billing']);
        }

        // 4. Update Shipping Address
        $sub = $user->latestSubscription();
        if ($sub) {
            $shippings = $request->input('shippings', []);
            foreach ($shippings as $ship) {
                $bookSub = $sub->book_subscriptions()->find($ship['id']);
                if ($bookSub) {
                    $shippingData = $ship['sameAsBilling'] ? $data['billing'] : $ship;
                    $shippingAddr = $bookSub->address;
                    if (!$shippingAddr) {
                        $shippingAddr = \App\Address::create([
                            'line1' => $shippingData['line1'] ?? '',
                            'line2' => $shippingData['line2'] ?? null,
                            'city' => $shippingData['city'] ?? '',
                            'state' => $shippingData['state'] ?? '',
                            'zip_code' => $shippingData['zip_code'] ?? '',
                            'special_instructions' => $shippingData['special_instructions'] ?? null,
                        ]);
                        $bookSub->address_id = $shippingAddr->id;
                        $bookSub->save();
                    } else {
                        $shippingAddr->update([
                            'line1' => $shippingData['line1'] ?? '',
                            'line2' => $shippingData['line2'] ?? null,
                            'city' => $shippingData['city'] ?? '',
                            'state' => $shippingData['state'] ?? '',
                            'zip_code' => $shippingData['zip_code'] ?? '',
                            'special_instructions' => $shippingData['special_instructions'] ?? null,
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'user' => $user->fresh(['company.address']),
            'shippingAddresses' => $sub ? $sub->load('book_subscriptions.address')->book_subscriptions : collect(),
        ]);
    }

    public function changePassword(Request $request) {
        $user = Auth::user();
        if (!$user) {
            $token = $request->bearerToken() ?: $request->input('api_token');
            if ($token) {
                $user = User::where('api_token', $token)->first();
            }
        }
        if (!$user) {
            $res = response()->json(['errors' => ['current_password' => ['Unauthenticated.']]], 401);
            throw new HttpResponseException($res);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
        ]);

        $validator->after(function($v) use ($data, $user) {
            if(! \Hash::check($data['current_password'], $user->password)) {
                $v->errors()
                    ->add('current_password', 'Old password did not match our records.');
            }
        });

        $validator->validate();

        $user->setPassword($data['password']);
    }

    public function showRenew(Request $request) {
        $u = Auth::user();
        $sub = $u->activeSubscription();
        if (!$sub) {
            return redirect()->route('auth.account')
                ->with(['message' => "No active subscription found."]);
        }
        $cycle = $sub->getLatestCycle();
        if (!$cycle || empty($cycle->ends_on)) {
            return redirect()->route('auth.account')
                ->with(['message' => "Could not retrieve the subscription cycle end date."]);
        }
        $card='';

        // only allow renewal if cycle is within 90 days of ending
        $end = new Carbon($cycle->ends_on);
        $renewalWindow = Carbon::now()->addDays(90);
        if ($end->greaterThan($renewalWindow)) {
            $e = $end->toFormattedDateString();
            return redirect()->route('auth.account')
                ->with(['message' => "You are not within the renewal window. Your subscription won't end until $e."]);
        }

        return view('auth.account.renew', [
            'user' => $u,
            'subscription' => $sub,
            'bookSubscriptions' => $sub->book_subscriptions()->with('address')->get(),
            'addons' => $sub->addons()->get(),
            'cycle_end' => $end->toFormattedDateString(),
            'currentPaymentMethod' => $cycle->payment_method,
           'card' => $card,
        ]);
    }

    public function renewSubscription(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
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
            'book_subscriptions_to_remove' => 'nullable|string',

            'addons.*' => 'required|distinct|email|max:255',
            'addons_to_remove' => 'nullable|string',

            'payment_method' => 'required_unless:subscription_length,0|string',
            'stripe_token' => 'nullable|required_if:payment_method,==,stripe|string|max:255',
        ]);

        $validator->validate();

        $user = Auth::user();
        $sub = $user->activeSubscription();

        if (!empty($data['stripe_token'])) {
            try {
                $cust = \Stripe\Customer::retrieve($user->stripe_id);
                $cust->source = $data['stripe_token'];
                $cust->save();
            } catch (\Stripe\Error\Base $e) {
                return $this->handle_stripe_error($e);
            }
        }

        $sub->frequency = (int) $data['subscription_length'];
        $sub->save();

        $currentCycle = $sub->getCurrentCycle() ?: $sub->getLatestCycle();
        $startsOn = ($currentCycle && $currentCycle->ends_on) ? $currentCycle->ends_on : Carbon::now()->toDateString();

        $cycle = $sub->cycles()->create([
            'payment_method' => $data['payment_method'],
            'starts_on' => $startsOn,
        ]);

        if ($sub->frequency === config('subscriptions.duration_one_year')) {
            $base_cost = config('subscriptions.one_year_online') * Globals::STRIPE_MULTIPLIER;
        } else {
            $base_cost = config('subscriptions.two_year_online') * Globals::STRIPE_MULTIPLIER;
        }

        $subLength = $data['subscription_length'];
        $user->addInvoiceItem([
            'amount' => $base_cost,
            'description' => "$subLength Month Online Subscription to The California Target Book",
            'metadata' => [ 'cycle_id' => $cycle->id ],
        ]);

        /**
         * Hard Copy Subscriptions
         */
        // Delete old
        $bookIds = array_map('intval', explode(',', $data['book_subscriptions_to_remove']));
        BookSubscription::destroy($bookIds);

        // Add new
        $book_cost = Globals::getBookSubscriptionPrice($sub->frequency);
        $new_book_subs = collect($data['book_addresses'])
            ->map(function ($addr) use (&$sub, &$user) {
                $address = Address::create($addr);
                $book_sub = $sub->book_subscriptions()
                    ->create([
                        'user_id' => $user->id,
                        'address_id' => $address->id 
                    ]);
                $book_sub->address = $address;
                return $book_sub;
            });

        $book_subs = $sub->book_subscriptions()->get();

        $book_subs->each(function ($bs) use (&$user, &$sub, $subLength, $book_cost) {
            $addr_line1 = $bs->address->line1;
            $user->addInvoiceItem([
                'amount' => $book_cost,
                'description' => "$subLength Month Hard Copy Subscription to $addr_line1",
            ]);
        });

        /**
         * Addons
         */
        // remove old
        $addonIds = array_map('intval', explode(',', $data['addons_to_remove']));
        $sub->addons()->detach($addonIds);

        // add new
        $company = $user->company()->first();
        $new_addons = collect($data['addons'])
            ->map(function ($addonEmail) use (&$sub, $company, $data) {
                $existing = User::where(['email' => $addonEmail])->first();
                $addonBody = [
                    'email' => $addonEmail,
                    'email_token' => base64_encode($addonEmail),
                    'company_id' => $company->id,
                ];

                $addon = $existing ?? User::make();
                $addon->fill($addonBody);

                return $sub->users()
                    ->save($addon, ['role' => SubscriptionUser::ADDON]);
            });

        $addons = $sub->addons()->get();
        $addon_cost = config('subscriptions.additional_seat') * Globals::STRIPE_MULTIPLIER;
        $addons->each(function ($addon) use (&$user, &$sub, $subLength, $addon_cost) {
            $descTemplate = config('subscriptions.names.addon_description', ':title Online Subscription Addon Account, for :email');
            $subTitle = "$subLength Month";
            $description = str_replace([':title', ':email'], [$subTitle, $addon->email], $descTemplate);
            $user->addInvoiceItem([
                'amount' => $addon_cost,
                'description' => $description,
            ]);
        });

        // Store renewed additional online users count in Owner's row
        $owner = User::find($sub->account_id);
        if ($owner) {
            $owner->additional_online_users = $addons->count();
            $owner->save();
        }

        /**
         * Issue stripe invoice
         */
        $invoice = $user->createInvoice([
            'description' => 'California Target Book Online Subscription',
            'metadata' => [ 'cycle_id' => $cycle->id, 'subscription_id' => $sub->id ],
        ]);

        $cycle->invoice_id = $invoice->id;
        $cycle->save();
        if ($cycle->payment_method === 'stripe') {
          try {
            // Stripe usually waits 1-2 hours to charge for invoice,
            // but we want to do it now.
            $invoice->pay();
            $data['is_paid_for'] = $invoice->paid;

          } catch (\Stripe\Error\Base $e) {
            $invoice->closed = true;
            $invoice->metadata = [ 'failed' => true, 'cycle_id' => $cycle->id, 'subscription_id' => $sub->id ];
            $invoice->save();
            $cycle->delete();

            $new_book_subs->forEach(function ($sub) { $sub->delete(); });
            $new_addons->forEach(function ($a) { $a->delete(); });

            return $this->handle_stripe_error($e);
          }
        }

        dispatch(new SendInvoice($user, $invoice));

        if ($data['is_paid_for']) {
            $cycle->activate();
        }

        Session::forget('trial_end');
        Session::forget('cycle_end');

        Session::put('subscription_renewal', [
            'user' => $user,
            'invoice' => $invoice,
        ]);

        return redirect()->route('auth.account.renew-thank-you');
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

    public function showRenewThankYou() {
        if (!Session::has('subscription_renewal')) {
            return redirect()->route('home');
        }

        return view('auth.account.renew-thank-you', Session::get('subscription_renewal'));
    }


    public function verifyBank(Request $request) {
        $u = Auth::user();
        if (!$u) {
            $token = $request->bearerToken() ?: $request->input('api_token');
            if ($token) {
                $u = User::where('api_token', $token)->first();
            }
        }
        if (!$u) {
            $res = response()->json(['errors' => ['stripe_token' => ['Unauthenticated.']]], 401);
            throw new HttpResponseException($res);
        }

        $validation = [ 'deposits' => 'array' ];
        $data = $request->all();
        $val = Validator::make($data, $validation);
        $val->validate();
        $cust = \Stripe\Customer::retrieve($u->stripe_id);
        $ba = $cust->sources->data[0];

        try {
            $ba->verify([ 'amounts' => $data['deposits'] ]);
        } catch(\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            $res = response()
                ->json([ 'errors' => [ 'stripe_token' => [$body['error']['message']] ] ], 422);
            throw new HttpResponseException($res);
        }

        $pendingCycle = $u->latestSubscription()
            ->cycles()
            ->get()
            ->first(function ($c) { return $c->isPending(); });

        try {
            $invoice = \Stripe\Invoice::retrieve($pendingCycle->invoice_id);
            $invoice->pay();
        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            $res = response()
                ->json([ 'errors' => [ 'stripe_token' => [$body['error']['message']] ] ], 422);
            throw new HttpResponseException($res);
        }

        $invoice->refresh();
        if ($invoice->paid) {
            $pendingCycle->activate();
        }

    }

    public function manageBilling()
    {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.manage_subscription', $data);
    }

    public function updateBilling(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'stripe_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $stripe_token = $request->input('stripe_token');

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

            $cust->source = $stripe_token;
            $cust->save();

            return response()->json([
                'success' => true,
                'message' => 'Billing details updated successfully.',
            ]);

        } catch (\Exception $e) {
            \Log::error("Failed to update billing card details: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function cancelSubscription()
    {
        $user = Auth::user();
        $sub = $user->latestSubscription();

        if (empty($sub)) {
            return redirect()->back()->with('message', 'No active subscription found.');
        }

        try {
            $stripeKey = config('services.stripe.secret') ?: (config('app.STRIPE_KEY') ?: env('STRIPE_KEY'));
            
            // 1. Cancel on Stripe if a Stripe subscription ID is linked
            if ($sub->wordpress_subscription_id && strpos($sub->wordpress_subscription_id, 'sub_') === 0) {
                if ($stripeKey) {
                    \Stripe\Stripe::setApiKey($stripeKey);
                    try {
                        $stripeSub = \Stripe\Subscription::retrieve($sub->wordpress_subscription_id);
                        if ($stripeSub && $stripeSub->status !== 'canceled') {
                            $stripeSub->cancel();
                        }
                    } catch (\Exception $stripeEx) {
                        \Log::warning('Stripe cancel during customer self-cancel failed: ' . $stripeEx->getMessage());
                    }
                }
            }

            // 2. Update local database
            $sub->status = 'cancelled';
            $sub->next_payment = null;
            $sub->save();

            return redirect()->back()->with('message', 'Your subscription has been cancelled successfully.');

        } catch (\Exception $e) {
            \Log::error('Subscription Cancel Failed: ' . $e->getMessage());
            return redirect()->back()->with('message', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }

    public function inviteAddon(Request $request)
    {
        $user = Auth::user();
        $sub = $user->latestSubscription();
        if (empty($sub)) {
            return response()->json(['success' => false, 'message' => 'No active subscription found.'], 400);
        }

        // Enforce dynamic seats limit based on owner's additional_online_users
        $owner = User::find($sub->account_id);
        $maxAddons = $owner ? (int) ($owner->additional_online_users ?? 0) : 4;
        $addonsCount = $sub->addons()->count();
        if ($addonsCount >= $maxAddons) {
            return response()->json(['success' => false, 'message' => 'You have reached the limit of ' . $maxAddons . ' seats. Remove a member to invite more.'], 400);
        }

        $validation = [
            'email' => 'required|email|max:255',
        ];

        $data = $request->only(['email']);
        $val = Validator::make($data, $validation);
        if ($val->fails()) {
            return response()->json(['success' => false, 'errors' => $val->errors()], 422);
        }

        $email = $data['email'];

        // Check if user is the owner
        if (strtolower($email) === strtolower($user->email)) {
            return response()->json(['success' => false, 'message' => 'This email belongs to the subscription owner.'], 400);
        }

        // Check if user is already an addon on this subscription
        $isAlreadyAddon = $sub->addons()->where('email', $email)->exists();
        if ($isAlreadyAddon) {
            return response()->json(['success' => false, 'message' => 'This user is already a member of your subscription.'], 400);
        }

        // Check if user already has an active subscription or is a member of another subscription
        $existingUser = User::where('email', $email)->first();
        if ($existingUser && $existingUser->hasActiveSubscription()) {
            return response()->json(['success' => false, 'message' => 'This email is already associated with an active subscription.'], 400);
        }

        try {
            $addon = $sub->addUser($email, [
                'first_name' => '',
                'last_name' => '',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Invitation sent successfully.',
                'addon' => [
                    'id' => $addon->id,
                    'name' => trim($addon->name()) ?: 'Pending Profile',
                    'email' => $addon->email,
                    'role' => 'Member',
                    'status' => $addon->verified ? 'Active' : 'Pending',
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Addon invite failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to invite user: ' . $e->getMessage()], 500);
        }
    }

    public function removeAddon(Request $request)
    {
        $user = Auth::user();
        $sub = $user->latestSubscription();
        if (empty($sub)) {
            return response()->json(['success' => false, 'message' => 'No active subscription found.'], 400);
        }

        $addonId = $request->input('id');
        if (empty($addonId)) {
            return response()->json(['success' => false, 'message' => 'User ID is required.'], 400);
        }

        // Verify the addon actually belongs to this subscription
        $addon = $sub->addons()->where('users.id', $addonId)->first();
        if (empty($addon)) {
            return response()->json(['success' => false, 'message' => 'Addon user not found in this subscription.'], 404);
        }

        try {
            // Detach user from subscription
            $addon->subscriptions()->detach($sub->id);

            return response()->json([
                'success' => true,
                'message' => 'User removed successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Addon removal failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to remove user: ' . $e->getMessage()], 500);
        }
    }

    public function reassignAddon(Request $request)
    {
        $user = Auth::user();
        $sub = $user->latestSubscription();
        if (empty($sub)) {
            return response()->json(['success' => false, 'message' => 'No active subscription found.'], 400);
        }

        $addonId = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');

        if (empty($addonId)) {
            return response()->json(['success' => false, 'message' => 'User ID is required.'], 400);
        }
        if (empty($email)) {
            return response()->json(['success' => false, 'message' => 'Email is required.'], 400);
        }

        // Verify the addon actually belongs to this subscription
        $oldAddon = $sub->addons()->where('users.id', $addonId)->first();
        if (empty($oldAddon)) {
            return response()->json(['success' => false, 'message' => 'Addon user not found in this subscription.'], 404);
        }

        // Check if user is the owner
        if (strtolower($email) === strtolower($user->email)) {
            return response()->json(['success' => false, 'message' => 'This email belongs to the subscription owner.'], 400);
        }

        // Check if user is already an addon on this subscription
        $isAlreadyAddon = $sub->addons()->where('email', $email)->where('users.id', '!=', $addonId)->exists();
        if ($isAlreadyAddon) {
            return response()->json(['success' => false, 'message' => 'This user is already a member of your subscription.'], 400);
        }

        // Check if user already has an active subscription elsewhere
        $existingUser = User::where('email', $email)->first();
        if ($existingUser && $existingUser->id != $addonId && $existingUser->hasActiveSubscription()) {
            return response()->json(['success' => false, 'message' => 'This email is already associated with an active subscription.'], 400);
        }

        // Parse Name into first_name and last_name
        $parts = explode(' ', trim($name ?? ''), 2);
        $firstName = $parts[0] ?? '';
        $lastName = $parts[1] ?? '';

        try {
            // 1. Detach old user
            $oldAddon->subscriptions()->detach($sub->id);

            // 2. Add new user
            $newAddon = $sub->addUser($email, [
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User reassigned successfully.',
                'addon' => [
                    'id' => $newAddon->id,
                    'name' => trim($newAddon->name()) ?: 'Pending Profile',
                    'email' => $newAddon->email,
                    'role' => 'Member',
                    'status' => $newAddon->verified ? 'Active' : 'Pending',
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Addon reassignment failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to reassign user: ' . $e->getMessage()], 500);
        }
    }


    public function purchaseSeatsPost(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'seats' => 'required|integer|min:1|max:50',
            'stripe_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $seats = (int) $request->input('seats');
        $stripe_token = $request->input('stripe_token');
        $amount = $seats * config('subscriptions.additional_seat') * 100; // per seat in cents

        try {
            $stripeKey = config('services.stripe.secret') ?: (config('app.STRIPE_KEY') ?: env('STRIPE_KEY'));
            \Stripe\Stripe::setApiKey($stripeKey);

            
            // 1. Ensure user has a Stripe customer ID
            if (empty($user->stripe_id)) {
                $customer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->first_name . ' ' . $user->last_name,
                ]);
                $user->stripe_id = $customer->id;
                $user->save();
            }

            $cust = \Stripe\Customer::retrieve($user->stripe_id);

            // 2. Attach payment source
            $cust->source = $stripe_token;
            $cust->save();

            // 3. Create Stripe Charge
            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'customer' => $cust->id,
                'description' => "Purchase of {$seats} Additional User Seat(s) - California Target Book",
            ]);

            if ($charge->paid) {
                // 4. Update owner's user record in db
                $sub = $user->latestSubscription();
                $owner = $sub ? User::find($sub->account_id) : null;
                if (!$owner) {
                    $owner = $user;
                }

                $owner->additional_online_users = ((int) $owner->additional_online_users) + $seats;
                $owner->save();

                // Save transaction to local database
                try {
                    \App\Transaction::create([
                        'user_id' => $user->id,
                        'subscription_id' => $sub ? $sub->id : null,
                        'stripe_charge_id' => $charge->id ?? null,
                        'stripe_invoice_id' => null,
                        'description' => "Purchase of {$seats} Additional User Seat(s) - California Target Book",
                        'plan' => 'Seat - Yearly',
                        'amount' => $amount,
                        'status' => 'Completed',
                        'payment_method' => 'stripe',
                        'invoice_url' => $charge->receipt_url ?? null,
                        'raw_stripe_data' => isset($charge) ? $charge->jsonSerialize() : null,
                        'transaction_date' => now(),
                    ]);
                } catch (\Exception $txEx) {
                    \Log::error("Failed to save transaction record in purchaseSeatsPost: " . $txEx->getMessage());
                }

                // 5. Update Stripe Subscription if it exists so it's added to Upcoming Invoice
                if ($sub && !empty($sub->wordpress_subscription_id) && strpos($sub->wordpress_subscription_id, 'sub_') === 0) {
                    try {
                        $stripeSub = \Stripe\Subscription::retrieve($sub->wordpress_subscription_id);
                        $addonPriceId = env('STRIPE_ADDON_PRICE_ID');
                        $foundItem = null;

                        foreach ($stripeSub->items->data as $item) {
                            $productId = $item->price->product ?? ($item->plan->product ?? '');
                            if (
                                $item->price->id === $addonPriceId || 
                                $productId === 'prod_additional_online_user' ||
                                stripos($item->plan->nickname ?? '', 'Additional') !== false || 
                                stripos($item->price->nickname ?? '', 'Additional') !== false
                            ) {
                                $foundItem = $item;
                                break;
                            }
                        }

                        if ($foundItem) {
                            \Stripe\SubscriptionItem::update($foundItem->id, [
                                'quantity' => $foundItem->quantity + $seats,
                                'proration_behavior' => 'none',
                            ]);
                        } else {
                            \Stripe\SubscriptionItem::create([
                                'subscription' => $stripeSub->id,
                                'price' => $addonPriceId,
                                'quantity' => $seats,
                                'proration_behavior' => 'none',
                            ]);
                        }
                    } catch (\Exception $e) {
                        \Log::error("Failed to update Stripe Subscription {$sub->wordpress_subscription_id} for Additional Seats: " . $e->getMessage());
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => "Successfully purchased {$seats} additional seat(s).",
                    'additional_online_users' => $owner->additional_online_users,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Stripe charge was not paid successfully.',
                ], 402);
            }

        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            return response()->json([
                'success' => false,
                'message' => $body['error']['message'] ?? 'Stripe error occurred.',
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Failed to purchase seats: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process purchase: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addSubscriptionPage()
    {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.add_subscription', $data);
    }

    public function checkSubscriberStatus(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Email is required.'
            ], 400);
        }

        $user = \App\User::where('email', $email)->first();

        if ($user && $user->hasActiveSubscription()) {
            return response()->json([
                'success' => true,
                'has_subscription' => true,
                'message' => 'User has an active subscription.'
            ]);
        }

        return response()->json([
            'success' => true,
            'has_subscription' => false,
            'message' => 'User does not have an active subscription.'
        ]);
    }
}
