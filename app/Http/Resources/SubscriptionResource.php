<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SubscriptionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        $cycles = $this->cycles()->latest()->get();
        $company = $this->subscriber()->first()->company()->with('address')->first();

        $cyclesWithInvoices = $cycles->map(function ($c) {
            try {
                $c->invoice = \Stripe\Invoice::retrieve($c->invoice_id);
            } catch (\Stripe\Error\Base $e) {
                // no invoice
            }
            return $c;
        });

        return [
            'id' => $this->id,
            'accountId' => $this->account_id,
            'frequency' => $this->frequency,
            'company' => $company,
            'pivot' => $this->pivot,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'users' => $this->users()
                ->get(['id', 'first_name', 'last_name', 'email']),
            'bookSubscriptions' => $this->load('book_subscriptions.address')->book_subscriptions,
            'cycles' => $cyclesWithInvoices,
            'cycle' => $cyclesWithInvoices->first(function ($c) {
                return $c->isCurrent();
            }),
            'inactiveCycles' => $cyclesWithInvoices->filter(function ($c) {
                return !$c->isCurrent();
            })->values(),
            'isActive' => $this->isActive(),
        ];
    }
}
