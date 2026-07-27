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
        $productName = \App\Subscription::determineProductName((int)$this->frequency, $hasPrint);

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
