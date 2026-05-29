<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Company;
use App\EventTicket;
use App\Jobs\SendInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventsController extends Controller
{
    //
    private $events = [
        'road-to-november-2018' => [
            'public' => false,
            'name' => 'Sacramento Post Primary Analysis',
            'slug' => 'road-to-november-2018',
            'ticket_price' => 5000,
            'sold_out' => true,
            'view' => 'events.road-to-november-2018',
            'date' =>  'Monday, June 11, 2018 <br/> 2:30 pm to 6:30 pm',
        ],
        'march-to-2020' => [
            'public' => false,
            'name' => 'March to 2020',
            'slug' => 'march-to-2020',
            'ticket_price' => 6000,
            'sold_out' => false,
            'view' => 'events.march-to-2020',
            'date' =>  'Monday, June 10, 2019 <br/> 1:00 pm to 4:30 pm',
        ],
    ];

    private function findEvent($ev, $publicOnly = true) {
        $e = $this->events[$ev];
        if ($publicOnly && !$e['public']) {
            return null;
        }
        return $e;
    }

    public function show($ev) {
        $event = $this->findEvent($ev);

        if (empty($event)) {
            return abort(404);
        }
        return view($event['view']);
    }

    public function rsvp($ev, Request $request) {
        $event = $this->findEvent($ev);

        if ($event['sold_out']) return redirect()->back();

        $data = $request->all();

        Validator::make($data, [
            'buyer_id' => 'nullable|integer',
            'email' => 'required|string|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'ticket_holders.*' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'stripe_token' => 'nullable|required_if:payment_method,==,stripe|string|max:255',
        ])->validate();


        if (!empty($data['buyer_id'])) {
            $user = User::find((int) $data['buyer_id']);
        }
        if (empty($user)) {
            $user = User::where('email', $data['email'])->first();
        }

        // Find or create user
        if (empty($user)) {
            $company = Company::create([ 'name' => $data['company'] ]);

            $user = User::create([
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'email_token' => base64_encode($data['email']),
                'company_id' => $company->id,
            ]);

            // make sure we don't save the user again, in case of form fail
            Session::put('_old_input.buyer_id', $user->id);
        }


        if (!isset($user->stripe_id)) {
            try {
                $cust = \Stripe\Customer::create([
                    'description' => $data['company'] . ': ' . $data['first_name'] . ' ' . $data['last_name'],
                    'email' => $data['email'],
                    'source' => $data['stripe_token'],
                    'metadata' => [ 'payment_method' => $data['payment_method'] ],
                ]);
            } catch (\Stripe\Error\Base $e) {
                $body = $e->getJsonBody();
                $res = back()
                    ->withInput()
                    ->withErrors([ 'stripe_token' => [$body['error']['message']] ]);
                throw new HttpResponseException($res);
            }
            $user->stripe_id = $cust->id;
            $user->save();
        }

        if (empty($cust) && $data['payment_method'] === 'stripe') {

            $cust = \Stripe\Customer::retrieve($user->stripe_id);

            try {
                $cust->source = $data['stripe_token'];
                $cust->save();
            } catch (\Stripe\Error\Base $e) {
                $body = $e->getJsonBody();
                $res = back()
                    ->withInput()
                    ->withErrors([ 'stripe_token' => [$body['error']['message']] ]);
                throw new HttpResponseException($res);
            }
        }

        $evName = $event['name'];
        $ticketCount = count($data['ticket_holders']);

        $user->addInvoiceItem([
            'unit_amount' => $event['ticket_price'],
            'quantity' => $ticketCount,
            'description' => "Ticket to the California Target Book Event: $evName)",
        ]);

        $invoice = $user->createInvoice([
            'description' => "Ticket(s) to the California Target Book Event: $evName)",
        ]);

        $invoice->save();

        if ($data['payment_method'] === 'stripe') {
            try {
                $invoice->pay();
            } catch (\Stripe\Error\Base $e) {
                $body = $e->getJsonBody();
                $res = back()
                    ->withInput()
                    ->withErrors([ 'stripe_token' => [$body['error']['message']] ]);
                throw new HttpResponseException($res);
            }
        }

        $tickets = collect($data['ticket_holders'])
            ->map(function ($holder) use ($user, $ev, $invoice) {
                return EventTicket::create([
                    'holders_name' => $holder,
                    'event' => $ev,
                    'buyer_id' => $user->id,
                    'invoice_id' => $invoice->id,
                    'is_paid_for' => $invoice->paid,
                ]);
            })
            ->toArray();

        dispatch(new SendInvoice($user, $invoice));

        Session::put('event_order', [
            'event' => $event,
            'invoice' => [
                'total' => $invoice->total,
                'id' => $invoice->number,
                'is_paid' => $invoice->paid,
                'ticketCount' => $ticketCount,
            ],
        ]);

        return redirect()->route('events.thank-you');
    }

    public static function showThankYou() {
        if (!Session::has('event_order')) {
            return redirect()->route('home');
        }

        return view('events.thank-you', Session::get('event_order'));
    }

    // show all events
    public function index() {

        $counts = EventTicket::groupBy('event')
            ->select('event', \DB::raw('count(*) as total'))
            ->get();

        $events = collect(array_values($this->events))
            ->map(function ($ev) use ($counts) {
                $ev['ticketsBought'] = $counts->firstWhere('event', $ev['slug'])->total;
                $ev['ticketPrice'] = $ev['ticket_price'];
                return $ev;
            })
            ->toArray();

        return response()
            ->json($events);
    }

    // Show single event
    public function getEvent($ev) {
        $event = $this->findEvent($ev, false);

        $tickets = EventTicket::where('event', $ev)->get();

        $buyers = [];

        $tickets->map(function ($t) use (&$buyers) {
            if (!$buyers[$t->buyer_id]) {
                $u = User::find($t->buyer_id);
                if ($u) $u = $u->profile();
            }
            $t->buyer = $u;
            $t->is_paid_for = (boolean) $t->is_paid_for;

            return $t;
        });

        $event['tickets'] = $tickets;

        return response()->json($event);
    }

    public function updateTicket(Request $request, $eventId, $ticketId) {
        $validation = [
            'is_paid_for' => 'nullable|boolean',
            'checked_in_at' => 'nullable|date',
        ];
        $data = $request->only([ 'is_paid_for', 'checked_in_at' ]);
        $val = Validator::make($data, $validation);
        $val->validate();

        if ($data['checked_in_at']) $data['checked_in_at'] = Carbon::parse($data['checked_in_at']);

        $ticket = EventTicket::find($ticketId);
        $ticket->update($data);
        return $ticket;
    }
}
