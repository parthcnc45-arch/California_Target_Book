<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionOverviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $u = $this->subscriber()->first();
        if ($u) {
            $usersName = $u->name();
            $company = $u->company()->first();
            if ($company) {
                $companyName = $company->name;
            }
        }

        $hasPrint = $this->book_subscriptions()
            ->whereIn('item_name', ['California Target Book', '-'])
            ->count() > 0;
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
            'company' => $companyName ?? '',
            'baseAccount' => [
                'id' => $u?->id ?? '',
                'email' => $u?->email ?? '',
                'name' => $usersName ?? '',
            ],
            'productName' => $productName,
            'isActive' => $this->isActive(),
            'frequency' => $this->frequency,
            'cycle' => $this->getCurrentCycle(),
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
