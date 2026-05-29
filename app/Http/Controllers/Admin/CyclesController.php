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

        $in = \Stripe\Invoice::retrieve($cycle->invoice_id);
        $in->closed = true;
        $in->forgiven = true;
        $in->save();
        $cycle->activate();

        $u = User::where('stripe_id', $in->customer)->first();

        dispatch(new SendSubscriptionMarkedPaid($u));

        return $cycle;
    }



}
