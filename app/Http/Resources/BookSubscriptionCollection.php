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
            $sub = Subscription::find($bookSub->subscription_id);
            if ($sub) {
                $subResource = new SubscriptionOverviewResource($sub);
            } else {
                $userObj = \App\User::find($bookSub->user_id);
                $companyObj = $userObj ? $userObj->company()->first() : null;
                $subResource = [
                    'id' => null,
                    'company' => $companyObj ? $companyObj->name : '',
                    'baseAccount' => [
                        'id' => $userObj ? $userObj->id : '',
                        'email' => $userObj ? $userObj->email : '',
                        'name' => $userObj ? $userObj->name() : 'Not Specified',
                    ],
                    'productName' => 'Post-Election Deck/Book Purchase',
                    'isActive' => false,
                    'frequency' => 0,
                    'cycle' => null,
                    'createdAt' => $bookSub->created_at ? $bookSub->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                ];
            }

            return [
                'id' => $bookSub->id,
                'subscription_id' => $bookSub->subscription_id,
                'carrier' => $bookSub->carrier,
                'tracking_id' => $bookSub->tracking_id,
                'tracking_url' => $bookSub->tracking_url,
                'ship_date' => $bookSub->ship_date,
                'estimated_delivery' => $bookSub->estimated_delivery,
                'status' => $bookSub->status,
                'item_name' => $bookSub->item_name,
                'address' => $bookSub->address()->first(),
                'subscription' => $subResource,
            ];
        })
            ->toArray();
    }
}
