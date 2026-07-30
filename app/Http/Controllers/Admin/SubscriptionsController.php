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

    public function index(Request $request) {
        $today = date('Y-m-d');
        $query = Subscription::with(['cycles', 'users.company', 'book_subscriptions']);

        // Apply search filter
        if ($search = $request->input('search')) {
            $query->whereHas('users', function($uq) use ($search) {
                $uq->where('subscription_user.role', 'subscriber')
                   ->where(function($q) use ($search) {
                       $q->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhereHas('company', function($cq) use ($search) {
                             $cq->where('name', 'like', "%{$search}%");
                         });
                   });
            });
        }

        // Apply status filter
        $statusVal = $request->input('status', 'all');
        if ($statusVal !== 'all') {
            if ($statusVal === 'active') {
                $query->whereHas('cycles', function($cq) use ($today) {
                    $cq->where('starts_on', '<=', $today)
                      ->where('ends_on', '>=', $today);
                });
            } elseif ($statusVal === 'inactive') {
                $query->whereDoesntHave('cycles', function($cq) use ($today) {
                    $cq->where('starts_on', '<=', $today)
                      ->where('ends_on', '>=', $today);
                });
            }
        }

        // Apply term/frequency filter
        $frequencyVal = $request->input('frequency', 'all');
        if ($frequencyVal !== 'all') {
            $query->where('frequency', intval($frequencyVal));
        }

        // Apply starts_on date filter
        if ($startsOn = $request->input('starts_on')) {
            $query->whereHas('cycles', function($cq) use ($startsOn) {
                $cq->where('starts_on', '>=', $startsOn);
            });
        }

        // Apply ends_on date filter
        if ($endsOn = $request->input('ends_on')) {
            $query->whereHas('cycles', function($cq) use ($endsOn) {
                $cq->where('ends_on', '<=', $endsOn);
            });
        }

        // Order by created_at desc
        $query->orderBy('created_at', 'desc');

        // Global stats calculation
        $totalCount = Subscription::count();
        $activeCount = Subscription::whereHas('cycles', function($cq) use ($today) {
            $cq->where('starts_on', '<=', $today)
              ->where('ends_on', '>=', $today);
        })->count();
        $inactiveCount = $totalCount - $activeCount;

        // Support export
        if ($request->input('export') == 1) {
            $subscriptions = $query->get();
            return new SubscriptionCollection($subscriptions);
        }

        $limit = $request->input('limit', 10);
        $paginated = $query->paginate($limit);

        return response()->json([
            'data' => new SubscriptionCollection($paginated->getCollection()),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'from' => $paginated->firstItem(),
                'to' => $paginated->lastItem(),
            ],
            'stats' => [
                'total' => $totalCount,
                'active' => $activeCount,
                'inactive' => $inactiveCount,
            ]
        ]);
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

    public function indexHardCopies(Request $request) {
        $today = date('Y-m-d');
        
        $query = BookSubscription::where(function($q) {
            $q->whereNull('item_name')
              ->orWhere('item_name', 'not like', '%Deck%')
              ->where('item_name', 'not like', '%Presentation%');
        })->with(['subscription.cycles', 'subscription.users.company', 'address', 'user.company']);

        // Apply search filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->whereHas('subscription.users', function($uq) use ($search) {
                    $uq->where('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhereHas('company', function($cq) use ($search) {
                           $cq->where('name', 'like', "%{$search}%");
                       });
                })
                ->orWhereHas('user', function($uq) use ($search) {
                    $uq->where('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhereHas('company', function($cq) use ($search) {
                           $cq->where('name', 'like', "%{$search}%");
                       });
                })
                ->orWhereHas('address', function($aq) use ($search) {
                    $aq->where('line1', 'like', "%{$search}%")
                      ->orWhere('line2', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('state', 'like', "%{$search}%")
                      ->orWhere('zip_code', 'like', "%{$search}%")
                      ->orWhere('special_instructions', 'like', "%{$search}%");
                });
            });
        }

        // Apply status filter
        $statusVal = $request->input('status', 'all');
        if ($statusVal !== 'all') {
            if ($statusVal === 'active') {
                $query->whereHas('subscription.cycles', function($cq) use ($today) {
                    $cq->where('starts_on', '<=', $today)
                      ->where('ends_on', '>=', $today);
                });
            } elseif ($statusVal === 'inactive') {
                $query->where(function($q) use ($today) {
                    $q->whereNull('subscription_id')
                      ->orWhereDoesntHave('subscription.cycles', function($cq) use ($today) {
                          $cq->where('starts_on', '<=', $today)
                             ->where('ends_on', '>=', $today);
                      });
                });
            } else {
                $query->where('status', $statusVal);
            }
        }

        // Order by id desc
        $query->orderBy('id', 'desc');

        // Global stats calculation (always calculated on the base query filter)
        $baseStatsQuery = BookSubscription::where(function($q) {
            $q->whereNull('item_name')
              ->orWhere('item_name', 'not like', '%Deck%')
              ->where('item_name', 'not like', '%Presentation%');
        });

        $totalCount = (clone $baseStatsQuery)->count();
        $activeCount = (clone $baseStatsQuery)->whereHas('subscription.cycles', function($cq) use ($today) {
            $cq->where('starts_on', '<=', $today)
              ->where('ends_on', '>=', $today);
        })->count();
        $inactiveCount = $totalCount - $activeCount;
        $shippedCount = (clone $baseStatsQuery)->where('status', 'Shipped')->count();
        $deliveredCount = (clone $baseStatsQuery)->where('status', 'Delivered')->count();

        // Support export
        if ($request->input('export') == 1) {
            $bookSubscriptions = $query->get();
            return new BookSubscriptionCollection($bookSubscriptions);
        }

        $limit = $request->input('limit', 10);
        $paginated = $query->paginate($limit);

        return response()->json([
            'data' => new BookSubscriptionCollection($paginated->getCollection()),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'from' => $paginated->firstItem(),
                'to' => $paginated->lastItem(),
            ],
            'stats' => [
                'total' => $totalCount,
                'active' => $activeCount,
                'inactive' => $inactiveCount,
                'shipped' => $shippedCount,
                'delivered' => $deliveredCount,
            ]
        ]);
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
