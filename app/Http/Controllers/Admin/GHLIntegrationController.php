<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscription;
use App\SubscriptionUser;
use Illuminate\Support\Facades\Log;

class GHLIntegrationController extends Controller
{
    /**
     * Fetch all subscription data stored in the local database (Public/No-Auth).
     */
    public function getPublicSubscriptions()
    {
        $subscriptionsData = [];
        try {

            $subscriptions = Subscription::orderBy('created_at', 'desc')->get();

            foreach ($subscriptions as $sub) {
                $subscriber = $sub->subscriber()->first();
                
                if ($sub->frequency === 12) {
                    $frequencyText = '12 Month';
                } elseif ($sub->frequency === 24) {
                    $frequencyText = '24 Month';
                }

                $cycle = $sub->cycles()->first();
                $paymentMethod = $cycle ? $cycle->payment_method : 'stripe';

                $subscriptionsData[] = [
                    'id' => $sub->id,
                    'user_name' => $subscriber ? ($subscriber->first_name . ' ' . $subscriber->last_name) : 'N/A',
                    'user_email' => $subscriber ? $subscriber->email : 'N/A',
                    'stripe_sub_id' => $sub->wordpress_subscription_id ?: 'N/A',
                    'frequency' => $frequencyText,
                    'payment_method' => $paymentMethod,
                    'next_payment' => $sub->next_payment ?: 'N/A',
                    'end_date' => $sub->end_date ?: 'N/A',
                    'status' => $sub->status,
                    'created_at' => $sub->created_at ? $sub->created_at->toDateTimeString() : 'N/A',
                    'updated_at' => $sub->updated_at ? $sub->updated_at->toDateTimeString() : 'N/A'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Public Subscriptions Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch subscriptions: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'subscriptions' => $subscriptionsData,
            'stats' => [
                'total_subs' => count($subscriptionsData),
            ]
        ]);
    }
    /**
     * Cancel a subscription in the Laravel database.
     */
    public function cancelSubscription(Request $request, $stripeSubId)
    {
        try {
            $subscription = Subscription::where('wordpress_subscription_id', $stripeSubId)
                ->first();

            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription not found in database.'
                ], 404);
            }

            $cancelledOnStripe = false;

            // If the subscription ID looks like a Stripe subscription ID (starts with 'sub_')
            if (strpos($stripeSubId, 'sub_') === 0) {
                try {
                    $stripeKey = config('app.STRIPE_KEY') ?: env('STRIPE_KEY');
                    if ($stripeKey) {
                        \Stripe\Stripe::setApiKey($stripeKey);
                        $stripeSub = \Stripe\Subscription::retrieve($stripeSubId);
                        if ($stripeSub && $stripeSub->status !== 'canceled') {
                            $stripeSub->cancel();
                            $cancelledOnStripe = true;
                            Log::info('Stripe subscription cancelled successfully: ' . $stripeSubId);
                        }
                    } else {
                        Log::warning('Stripe API Key not configured during cancelSubscription for ' . $stripeSubId);
                    }
                } catch (\Exception $stripeEx) {
                    $errorMessage = $stripeEx->getMessage();
                    Log::error('Stripe cancel exception: ' . $errorMessage, [
                        'stripe_sub_id' => $stripeSubId
                    ]);

                    $isNotFoundError = (strpos($errorMessage, 'No such subscription') !== false);
                    $isAlreadyCanceledError = (strpos($errorMessage, 'already canceled') !== false || strpos($errorMessage, 'already been canceled') !== false);

                    if (!$isNotFoundError && !$isAlreadyCanceledError) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to cancel subscription on Stripe: ' . $errorMessage
                        ], 500);
                    }
                }
            }

            // Update local database status
            $subscription->status = 'cancelled';
            $subscription->next_payment = null;
            $subscription->save();

            return response()->json([
                'success' => true,
                'message' => $cancelledOnStripe
                    ? 'Subscription cancelled successfully in database and on Stripe.'
                    : 'Subscription cancelled successfully in database.'
            ]);
        } catch (\Exception $e) {
            Log::error('GHL API Cancel Subscription failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel subscription: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Delete a subscription and the subscriber user if they are linked.
     */
    public function pausedSubscription(Request $request, $stripeSubId)
    {
        try {
            $subscription = Subscription::where('wordpress_subscription_id', $stripeSubId)
                ->first();

            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription not found in database.'
                ], 404);
            }

            $pausedOnStripe = false;

            // If the subscription ID looks like a Stripe subscription ID (starts with 'sub_')
            if (strpos($stripeSubId, 'sub_') === 0) {
                try {
                    $stripeKey = config('app.STRIPE_KEY') ?: env('STRIPE_KEY');
                    if ($stripeKey) {
                        \Stripe\Stripe::setApiKey($stripeKey);
                        $stripeSub = \Stripe\Subscription::retrieve($stripeSubId);
                        if ($stripeSub) {
                            $stripeSub->pause_collection = [
                                'behavior' => 'void',
                            ];
                            $stripeSub->save();
                            $pausedOnStripe = true;
                            Log::info('Stripe subscription paused successfully: ' . $stripeSubId);
                        }
                    } else {
                        Log::warning('Stripe API Key not configured during pausedSubscription for ' . $stripeSubId);
                    }
                } catch (\Exception $stripeEx) {
                    $errorMessage = $stripeEx->getMessage();
                    Log::error('Stripe pause exception: ' . $errorMessage, [
                        'stripe_sub_id' => $stripeSubId
                    ]);

                    $isNotFoundError = (strpos($errorMessage, 'No such subscription') !== false);

                    if (!$isNotFoundError) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to pause subscription on Stripe: ' . $errorMessage
                        ], 500);
                    }
                }
            }

            // Update Cycles status
            $subscription->status = 'paused';
            $subscription->save();

            return response()->json([
                'success' => true,
                'message' => $pausedOnStripe
                    ? 'Subscription paused successfully in database and on Stripe.'
                    : 'Subscription paused successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('GHL API Pause Subscription failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to pause subscription: ' . $e->getMessage()
            ], 500);
        }
    }
}
