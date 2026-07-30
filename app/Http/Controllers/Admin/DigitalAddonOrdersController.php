<?php

namespace App\Http\Controllers\Admin;

use App\DigitalAddonOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DigitalAddonOrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = DigitalAddonOrder::with(['user.company', 'transaction']);

        // Apply search filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('company', function($cq) use ($search) {
                            $cq->where('name', 'like', "%{$search}%");
                        });
                  });
            });
        }

        // Apply item category filter
        $itemVal = $request->input('item', 'all');
        if ($itemVal !== 'all') {
            if ($itemVal === 'deck') {
                $query->where('item_name', 'like', '%Deck%');
            } elseif ($itemVal === 'presentation') {
                $query->where('item_name', 'like', '%Presentation%');
            }
        }

        // Order by id desc
        $query->orderBy('id', 'desc');

        // Global stats calculation
        $totalCount = DigitalAddonOrder::count();
        $paidCount = DigitalAddonOrder::where('payment_status', 'Paid')->count();
        $refundedCount = DigitalAddonOrder::where('payment_status', 'Refunded')->count();
        $sentCount = DigitalAddonOrder::where('delivery_status', 'Sent')->count();

        // Support export
        if ($request->input('export') == 1) {
            $orders = $query->get()->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer_id' => $order->user_id,
                    'customer_name' => $order->user ? $order->user->name() : 'Not Specified',
                    'customer_email' => $order->user ? $order->user->email : 'Not Specified',
                    'company_name' => ($order->user && $order->user->company) ? $order->user->company->name : 'None',
                    'item' => $order->item_name,
                    'amount' => $order->amount,
                    'payment_status' => $order->payment_status,
                    'delivery_status' => $order->delivery_status,
                    'order_date' => $order->created_at->format('Y-m-d H:i:s'),
                ];
            });
            return response()->json($orders);
        }

        $limit = $request->input('limit', 10);
        $paginated = $query->paginate($limit);

        $mappedItems = collect($paginated->items())->map(function ($order) {
            return [
                'id' => $order->id,
                'customer_id' => $order->user_id,
                'customer_name' => $order->user ? $order->user->name() : 'Not Specified',
                'customer_email' => $order->user ? $order->user->email : 'Not Specified',
                'company_name' => ($order->user && $order->user->company) ? $order->user->company->name : 'None',
                'item' => $order->item_name,
                'amount' => $order->amount,
                'payment_status' => $order->payment_status,
                'delivery_status' => $order->delivery_status,
                'order_date' => $order->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $mappedItems,
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
                'paid' => $paidCount,
                'refunded' => $refundedCount,
                'sent' => $sentCount,
            ]
        ]);
    }

    public function resendEmail($id)
    {
        $order = DigitalAddonOrder::findOrFail($id);
        $user = $order->user;

        if (!$user) {
            return response()->json(['message' => 'No customer associated with this order.'], 422);
        }

        try {
            Mail::to($user->email)->send(new \App\Mail\DigitalProductDelivery($user, $order->item_name));
            
            $order->delivery_status = 'Sent';
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Delivery email resent successfully.',
                'order' => $order
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to resend digital product delivery email: " . $e->getMessage());
            
            $order->delivery_status = 'Failed';
            $order->save();

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function refund($id)
    {
        $order = DigitalAddonOrder::findOrFail($id);
        $tx = $order->transaction;

        if (!$tx || !$tx->stripe_charge_id) {
            return response()->json(['message' => 'Stripe charge not found for this order.'], 422);
        }

        try {
            $stripeKey = config('services.stripe.secret') ?: (config('app.STRIPE_KEY') ?: env('STRIPE_KEY'));
            \Stripe\Stripe::setApiKey($stripeKey);

            $refund = \Stripe\Refund::create([
                'charge' => $tx->stripe_charge_id,
                'amount' => $order->amount, // refund amount in cents
            ]);

            $order->payment_status = 'Refunded';
            $order->save();

            // Update associated local transaction description or status if needed
            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully via Stripe.',
                'order' => $order
            ]);
        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            $msg = $body['error']['message'] ?? 'Stripe refund failed.';
            return response()->json(['message' => $msg], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Refund failed: ' . $e->getMessage()], 500);
        }
    }
}
