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
        $user->load('company.address');
        $sub = $user->latestSubscription();

        if (empty($sub)) {
            $prevSub = $user->subscriptions()->first();
            if (empty($prevSub)) {
                return [
                    'user' => $user,
                    'pending_bank' => null,
                    'cycles' => collect(),
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
                
                // Fetch product name from Stripe
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

        return [
            'user' => $user,
            'pending_bank' => $ba,
            'cycles' => $cycles,
            'sub' => [
                'cycle' => $currentCycle,
                'status' => $sub->status(),
                'end' => ($latestCycle && $latestCycle->ends_on) ? (new Carbon($latestCycle->ends_on))->toFormattedDateString() : null,
                'start' => ($currentCycle && $currentCycle->starts_on) ? (new Carbon($currentCycle->starts_on))->toFormattedDateString() : null,
                'base_account' => $base_account,
                'role' => $sub->pivot->role,
                'addons' => $sub->addons()->get(),
                'books' => $sub->load('book_subscriptions.address')->book_subscriptions,
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

    public function transactionHistory() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }

        $transactions = collect();
        $user = Auth::user();
        
        $stripeKey = config('services.stripe.secret') ?: (config('app.STRIPE_KEY') ?: env('STRIPE_KEY'));
        \Stripe\Stripe::setApiKey($stripeKey);

        foreach ($data['cycles'] as $c) {
            if (!empty($c->invoice_id)) {
                try {
                    $inv = \Stripe\Invoice::retrieve($c->invoice_id);
                    
                    $plan = '—';
                    $description = $inv->description ?? 'Subscription Charge';
                    
                    if ($inv->lines && isset($inv->lines->data[0])) {
                        $line = $inv->lines->data[0];
                        if (!empty($line->description)) {
                            $description = $line->description; 
                        }
                        
                        // Parse Plan
                        if (stripos($description, 'One-Year') !== false || stripos($description, '1 Year') !== false || (isset($line->plan) && $line->plan->interval === 'year' && $line->plan->interval_count === 1)) {
                            $plan = 'One-Year';
                        } elseif (stripos($description, 'Two-Year') !== false || stripos($description, '2 Year') !== false || (isset($line->plan) && $line->plan->interval === 'year' && $line->plan->interval_count === 2)) {
                            $plan = 'Two-Year';
                        } elseif (stripos($description, 'Addon') !== false) {
                            $plan = 'One-Year';
                        }
                    }
                    
                    $status = 'Pending';
                    if ($inv->paid) {
                        $status = 'Completed';
                        if ($inv->charge) {
                            try {
                                $charge = \Stripe\Charge::retrieve($inv->charge);
                                if ($charge->refunded) {
                                    $status = 'Refunded';
                                }
                            } catch (\Exception $e) {}
                        }
                    } else if ($inv->closed || $inv->status === 'void') {
                        $status = 'Refunded';
                    }
                    
                    $transactions->push((object)[
                        'date' => Carbon::createFromTimestamp($inv->created)->format('F j, Y'),
                        'timestamp' => $inv->created,
                        'description' => $description,
                        'plan' => $plan,
                        'amount' => '$' . number_format($inv->total / 100, 2),
                        'status' => $status,
                        'invoice_url' => route('auth.account.invoice', ['invoice_id' => $inv->id]),
                    ]);
                    continue;
                } catch (\Exception $e) {
                    \Log::error("Stripe Invoice Fetch Failed for ID {$c->invoice_id}: " . $e->getMessage());
                }
            }
            
            // Fallback to local cycle if invoice_id is empty or Stripe retrieval fails
            $plan = 'One-Year';
            if ($c->subscription && $c->subscription->frequency === 24) {
                $plan = 'Two-Year';
            }
            
            $amount = '$1,200.00';
            if ($c->subscription) {
                if ($c->subscription->frequency === 24) {
                    $amount = '$2,200.00';
                }
            }
            
            $transactions->push((object)[
                'date' => Carbon::parse($c->starts_on)->format('F j, Y'),
                'timestamp' => Carbon::parse($c->starts_on)->timestamp,
                'description' => $plan . ' Subscription — ' . ($c->isPending() ? 'Renewal' : 'Annual Renewal'),
                'plan' => $plan,
                'amount' => $amount,
                'status' => $c->isPending() ? 'Pending' : 'Completed',
                'invoice_url' => $c->invoice_id ? route('auth.account.invoice', ['invoice_id' => $c->invoice_id]) : null,
            ]);
        }

        $data['transactions'] = $transactions;

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
            
            return view('auth.account.invoice', [
                'user' => $user,
                'invoice' => $invoice,
                'sub' => $data['sub'],
            ]);
            
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

    public function settings() {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.settings', $data);
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

        if ($sub->frequency === 12) {
            $base_cost = Globals::SUBSCRIPTION_COST_1YR;
        } else {
            $base_cost = Globals::SUBSCRIPTION_COST_2YR;
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
            ->map(function ($addr) use (&$sub) {
                $address = Address::create($addr);
                $book_sub = $sub->book_subscriptions()
                    ->create([ 'address_id' => $address->id ]);
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
        $addon_cost = Globals::ADDON_COST;
        $addons->each(function ($addon) use (&$user, &$sub, $subLength, $addon_cost) {
            $user->addInvoiceItem([
                'amount' => $addon_cost,
                'description' => "$subLength Month Online Subscription Addon Account, for $addon->email",
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

    public function purchaseSeats()
    {
        $data = $this->getAccountData();
        if ($data === null) {
            return redirect()->route('register');
        }
        if ($data === 'renew') {
            return redirect()->route('auth.account.renew');
        }
        return view('auth.account.purchase_seats', $data);
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

}
