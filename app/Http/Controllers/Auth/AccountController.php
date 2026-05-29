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
    public function index() {
        $user = Auth::user();
        $user->load('company.address');
        $sub = $user->latestSubscription();

        if (empty($sub)) {
            $prevSub = $user->subscriptions()->first();
            if (empty($prevSub)) {
                Auth::logout();
                return redirect()->route('register');
            } else {
                return redirect()->route('auth.account.renew');
            }
        }

        $base_account = $user === $sub->account_id ? $user : User::find($sub->account_id);
        $currentCycle = $sub->getCurrentCycle();
        $latestCycle = $sub->getLatestCycle();


        // Can't find invoice
        try {
            $invoice = \Stripe\Invoice::retrieve($currentCycle->invoice_id);
        } catch (\Exception $e) {
            $invoice = null;
        }

        $ba = '';
        if (!empty($user->stripe_id)) {
            $cust = \Stripe\Customer::retrieve($user->stripe_id);
            if ($cust->sources && isset($cust->sources->data[0])) {
                $bank_account = $cust->sources->data[0];
                if (property_exists($bank_account, 'status') && $bank_account->status === 'new') {
                    $ba = $bank_account;
                }
            }
        }

        return view('auth.account.index', [
            'user' => $user,
            'pending_bank' => $ba,
            'sub' => [
                'cycle' => $currentCycle,
                'status' => $sub->status(),
                'end' => $latestCycle->ends_on ? (new Carbon($latestCycle->ends_on))->toFormattedDateString() : null,
                'start' => $currentCycle->starts_on ? (new Carbon($currentCycle->starts_on))->toFormattedDateString() : null,
                'base_account' => $base_account,
                'role' => $sub->pivot->role,
                'addons' => $sub->addons()->get(),
                'books' => $sub->load('book_subscriptions.address')->book_subscriptions,
                'invoice' => $invoice,
            ]
        ]);
    }

    public function changePassword(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
        ]);

        $user = Auth::user();

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
        $cycle = $sub->getLatestCycle();
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
            'cycle_end' => (new Carbon($cycle->ends_on))->toFormattedDateString(),
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

        $currentCycle = $sub->getCurrentCycle();

        $cycle = $sub->cycles()->create([
            'payment_method' => $data['payment_method'],
            'starts_on' => $currentCycle->ends_on,
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


        $validation = [ 'deposits' => 'array' ];
        $data = $request->all();
        $val = Validator::make($data, $validation);
        $val->validate();

        $u = Auth::user();
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

}
