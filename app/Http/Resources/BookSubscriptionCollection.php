<?php

namespace App\Http\Resources;

use App\Subscription;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\SubscriptionOverviewResource;

class BookSubscriptionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($bookSub) {
            return [
                'id' => $bookSub->id,
                'subscription_id' => $bookSub->subscription_id,
                'address' => $bookSub->address()->first(),
                'subscription' => new SubscriptionOverviewResource(Subscription::find($bookSub->subscription_id)),
            ];
        })
            ->toArray();
    }
}
