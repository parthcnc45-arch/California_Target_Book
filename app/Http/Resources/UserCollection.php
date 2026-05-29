<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => "$u->first_name $u->last_name",
                'email' => $u->email,
                'company' => $u->load('company')->company->name,
                'role' => $u->role,
                'hasActiveSubscription' => $u->hasActiveSubscription(),
                'createdAt' => $u->created_at->format('Y-m-d H:i:s'),
            ];
        })
            ->toArray();
    }
}
