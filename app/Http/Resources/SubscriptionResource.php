<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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

        // Generate dynamic product name based on frequency and book delivery
        $hasPrint = $this->book_subscriptions()->count() > 0;
        $formatString = $hasPrint ? 'Online Access & Print' : 'Online Access Only';
        
        if ((int)$this->frequency === config('subscriptions.duration_one_year')) {
            $years = config('subscriptions.duration_one_year') / 12;
            $label = $years >= 1 ? ($years . "-Year") : (config('subscriptions.duration_one_year') . "-Month");
            $productName = "CTB Online " . $label . " Subscription ($formatString)";
        } elseif ((int)$this->frequency === config('subscriptions.duration_two_year')) {
            $years = config('subscriptions.duration_two_year') / 12;
            $label = $years >= 1 ? ($years . "-Year") : (config('subscriptions.duration_two_year') . "-Month");
            $productName = "CTB Online " . $label . " Subscription ($formatString)";
        } elseif ((int)$this->frequency === 0) {
            $productName = "CTB Online Trial Subscription";
        } else {
            $productName = "CTB Online Subscription (" . $this->frequency . " Months)";
        }

        return [
            'id' => $this->id,
            'accountId' => $this->account_id,
            'frequency' => $this->frequency,
            'productName' => $productName,
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
