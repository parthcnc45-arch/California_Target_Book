<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    /**
     * Show the advertise page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('advertise.index');
    }

    /**
     * Show the classified ad submission form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSubmitForm()
    {
        $categories = \App\Models\ClassifiedCategory::where('status', 'Show')->orderBy('name', 'asc')->get();
        $rates = \App\Models\ClassifiedRate::where('status', 'Show')->orderBy('rate_amount', 'asc')->get();

        return view('advertise.submit', compact('categories', 'rates'));
    }

    public function processSubmit(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'duration' => 'required',
            'headline' => 'required|string|max:80',
            'body' => 'required|string|max:1000',
            'link_url' => 'nullable|url',
            'start_date' => 'required|date',
            'expire_date' => 'required|date',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'advertiser_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'stripe_token' => 'required|string',
        ]);

        $rate = \App\Models\ClassifiedRate::find($validated['duration']);
        $amountInCents = 0;
        $rateId = null;
        $rateAmount = 0;

        if ($rate) {
            $amountInCents = round($rate->rate_amount * 100);
            $rateId = $rate->id;
            $rateAmount = $rate->rate_amount;
        } else {
            $fallbacks = [
                '1_week' => 165,
                '2_weeks' => 330,
                '3_weeks' => 495,
                '1_month' => 585
            ];
            if (array_key_exists($validated['duration'], $fallbacks)) {
                $amountInCents = $fallbacks[$validated['duration']] * 100;
                $rateAmount = $fallbacks[$validated['duration']];
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid Ad Duration selected.'], 400);
            }
        }

        try {
            $stripeKey = config('services.stripe.secret') ?: (config('app.STRIPE_KEY') ?: env('STRIPE_KEY'));
            \Stripe\Stripe::setApiKey($stripeKey);

            $charge = \Stripe\Charge::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'source' => $validated['stripe_token'],
                'description' => "Classified Ad: " . $validated['headline'],
                'receipt_email' => $validated['advertiser_email']
            ]);

            if (!$charge->paid) {
                return response()->json(['success' => false, 'message' => 'Payment failed.'], 402);
            }

            // Save to database
            $classified = new \App\Classified();
            $classified->status = 'Pending';
            $classified->category = $validated['category'];
            $classified->organization_name = $validated['company'];
            $classified->title = $validated['headline'];
            $classified->body = $validated['body'];
            $classified->link_url = $validated['link_url'];
            $classified->starts_on = $validated['start_date'];
            $classified->ends_on = $validated['expire_date'];
            $classified->advertiser_email = $validated['advertiser_email'];
            $classified->first_name = $validated['first_name'];
            $classified->last_name = $validated['last_name'];
            $classified->phone_number = $validated['phone_number'];
            $classified->classified_rate_id = $rateId;
            $classified->rate_amount = $rateAmount;
            $classified->payment_status = 'Paid';
            $classified->save();

            // Send Email Receipt
            try {
                \Illuminate\Support\Facades\Mail::to($classified->advertiser_email)->send(new \App\Mail\ClassifiedReceipt($classified, $charge));
            } catch (\Exception $mailEx) {
                \Illuminate\Support\Facades\Log::error("Failed to send classified receipt email: " . $mailEx->getMessage());
            }

            return response()->json(['success' => true]);

        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            return response()->json([
                'success' => false,
                'message' => $body['error']['message'] ?? 'Stripe error occurred.',
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage(),
            ], 500);
        }
    }
}
