<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Cycle;
use App\User;
use App\Jobs\SendSubscriptionMarkedPaid;

class CyclesController extends Controller
{

    /**
     * Update a given Cycle
     */
    public function update(Request $request, $cycleId) {
        $validation = [
            'starts_on' => 'string',
            'ends_on' => 'string',
        ];
        $data = $request->only([ 'starts_on', 'ends_on' ]);
        $val = Validator::make($data, $validation);
        $val->validate();

        $cycle = Cycle::find($cycleId);
        $cycle->update($data);

        return $cycle;
    }

    /**
     * Mark a cycle as paid and activate it
     */
    public function payCycle($cycleId) {
        $cycle = Cycle::find($cycleId);

        if ($cycle->isCurrent()) {
            return $cycle;
        }

        if (!empty($cycle->invoice_id)) {
            try {
                \Stripe\Stripe::setApiKey(config('app.STRIPE_KEY'));
                $in = \Stripe\Invoice::retrieve($cycle->invoice_id);
                $in->closed = true;
                $in->forgiven = true;
                $in->save();
                
                $u = User::where('stripe_id', $in->customer)->first();
                if ($u) {
                    dispatch(new SendSubscriptionMarkedPaid($u));
                }
            } catch (\Exception $e) {
                \Log::error("Failed to update Stripe invoice {$cycle->invoice_id} for cycle {$cycleId}: " . $e->getMessage());
            }
        } else {
            $sub = $cycle->subscription()->first();
            $u = $sub ? $sub->users()->wherePivot('role', 'subscriber')->first() : null;
            if ($u) {
                dispatch(new SendSubscriptionMarkedPaid($u));
            }
        }

        $cycle->activate();

        return $cycle;
    }



}
