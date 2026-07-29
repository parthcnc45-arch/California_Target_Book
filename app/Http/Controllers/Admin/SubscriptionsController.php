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

        // Prevent duplicate entries for the same subscription
        if ($sub->users()->where('email', $data['email'])->exists()) {
            return response()->json([
                'message' => 'This email is already associated with this subscription.'
            ], 422);
        }

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

        // Prevent duplicate cycles with same start date for the same subscription
        $startsOn = \Carbon\Carbon::parse($data['starts_on'])->format('Y-m-d');
        if ($sub->cycles()->where('starts_on', $startsOn)->exists()) {
            return response()->json([
                'message' => 'A cycle with this start date already exists for this subscription.'
            ], 422);
        }

        $sub->update([ 'frequency' => $data['length'] ]);
        $cycle = $sub->cycles()->create([
            'starts_on' => $data['starts_on'],
        ]);

        $cycle->activate();

        return $cycle;
    }

    public function indexHardCopies() {
        return new BookSubscriptionCollection(
            BookSubscription::where(function($query) {
                $query->whereNull('item_name')
                      ->orWhere('item_name', 'not like', '%Deck%')
                      ->where('item_name', 'not like', '%Presentation%');
            })->orderBy('id', 'desc')->get()
        );
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
            ->create([ 
                'address_id' => $address->id,
                'item_name' => $request->input('item_name', 'California Target Book')
            ]);

        return BookSubscription::with('address')->find($bs->id);
    }

    public function updateHardCopy($id, $bookId, Request $request) {

        $bs = BookSubscription::find($bookId);

        if ($request->has('address')) {
            $data = $request->only(['address']);
            Validator::make($data, [
                'address.line1' => 'required|string|max:255',
                'address.line2' => 'nullable|string|max:255',
                'address.city' => 'required|string|max:255',
                'address.state' => 'required|string|max:255',
                'address.zip_code' => 'required|string|max:255',
                'address.special_instructions' => 'nullable|string|max:255',
            ])->validate();
            $bs->address()->update($data['address']);
        }

        if ($request->has('shipment')) {
            $shipmentData = $request->input('shipment');
            
            $rules = [
                'status' => 'nullable|string|max:255',
                'carrier' => 'nullable|string|max:255',
                'tracking_id' => 'nullable|string|max:255',
                'tracking_url' => 'nullable|url|max:255',
                'ship_date' => 'nullable|date',
                'estimated_delivery' => 'nullable|date|after_or_equal:ship_date',
                'item_name' => 'nullable|string|max:255',
            ];

            $activeStatuses = ['Shipped', 'In Transit', 'Ready to Ship', 'Delivered'];
            $statusVal = $shipmentData['status'] ?? '';
            
            if (in_array($statusVal, $activeStatuses)) {
                $rules['carrier'] = 'required|string|max:255';
                $rules['tracking_id'] = 'required|string|max:255';
                $rules['ship_date'] = 'required|date';
            }

            Validator::make($shipmentData, $rules, [
                'carrier.required' => "Carrier is required when status is {$statusVal}.",
                'tracking_id.required' => "Tracking Number is required when status is {$statusVal}.",
                'ship_date.required' => "Ship Date is required when status is {$statusVal}.",
                'tracking_url.url' => 'Please enter a valid Tracking URL.',
                'estimated_delivery.after_or_equal' => 'Estimated Delivery date cannot be before the Ship Date.',
            ])->validate();
            
            $bs->update($shipmentData);

            // Sync updated shipment status to GoHighLevel
            $user = $bs->user ?: ($bs->subscription ? $bs->subscription->user : null);
            if ($user) {
                try {
                    $tags = config('app.GHL_ONE_TIME_BUYER_TAGS', ['one_time_buyer']);
                    if ($user->hasActiveSubscription()) {
                        $tags = array_merge($tags, config('app.GHL_SUBSCRIBER_TAGS', ['active_subscriber', 'CTB Active']));
                    }
                    dispatch_now(new \App\Jobs\SyncGHLContact($user, $tags));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('SyncGHLContact failed after shipment update: ' . $e->getMessage());
                }
            }
        }

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
