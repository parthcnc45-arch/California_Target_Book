<?php

namespace App\Http\Controllers\Admin;

use App\BookSubscription;
use Illuminate\Validation\Rule;
use App\Http\Resources\BookSubscriptionCollection;
use App\Http\Resources\SubscriptionCollection;
use App\Http\Resources\SubscriptionResource;
use App\Subscription;
use App\Address;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
    //

    public function index() {
        return new SubscriptionCollection(Subscription::orderBy('created_at', 'desc')->get());
    }

    // Get user by id
    public function get($id)
    {
        return new SubscriptionResource(Subscription::find($id));
    }

    public function createAddon(Request $request, $id) {
        $validation = [
            'email' => 'required|email|max:255',
            'first_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
        ];

        $data = $request->only(['email', 'first_name', 'last_name']);
        $val = Validator::make($data, $validation);
        $val->validate();

        $sub = Subscription::find($id);
        $sub->addUser($data['email'], $data);

        return new SubscriptionResource($sub);
    }

    public function createCycle(Request $request, $id) {

        $data = $request->only(['length', 'starts_on']);
        Validator::make($data, [
            'starts_on' => 'required|date',
            'length' => [
                'required',
                'numeric',
                Rule::in(Subscription::VALID_SUBSCRIPTION_LENGTHS),
            ],
        ])
            ->validate();

        $sub = Subscription::find($id);
        $sub->update([ 'frequency' => $data['length'] ]);
        $cycle = $sub->cycles()->create([
            'starts_on' => $data['starts_on'],
        ]);

        $cycle->activate();

        return $cycle;
    }

    public function indexHardCopies() {
        return new BookSubscriptionCollection(BookSubscription::all());
    }

    public function createHardCopy($id, Request $request) {

        $data = $request->only(['address']);
        Validator::make($data, [
            'address.line1' => 'required|string|max:255',
            'address.line2' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|max:255',
            'address.zip_code' => 'required|string|max:255',
            'address.special_instructions' => 'nullable|string|max:255',
        ])
            ->validate();

        $address = Address::create($data['address']);
        $bs = Subscription::find($id)->book_subscriptions()
            ->create([ 'address_id' => $address->id ]);

        return BookSubscription::with('address')->find($bs->id);
    }

    public function updateHardCopy($id, $bookId, Request $request) {

        $data = $request->only(['address']);
        Validator::make($data, [
            'address.line1' => 'required|string|max:255',
            'address.line2' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|max:255',
            'address.zip_code' => 'required|string|max:255',
            'address.special_instructions' => 'nullable|string|max:255',
        ])
            ->validate();

        $bs = BookSubscription::find($bookId);
        $bs->address()->update($data['address']);
        return BookSubscription::with('address')->find($bookId);
    }

    public function removeHardCopy($id, $bookId) {
        $bs = BookSubscription::find($bookId);
        $bs->delete();
        return $bs;
    }

    public function removeAddon($id, $addonId) {
        $u = User::find($addonId);
        $u->subscriptions()->detach($id);

        $sub = Subscription::find($id);
        return new SubscriptionResource($sub);
    }
}
