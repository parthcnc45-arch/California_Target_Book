<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\SubscriptionCollection;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => "$this->first_name $this->last_name",
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'has_password' => !empty($this->password),
            'phone_number' => $this->phone_number,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'company' => $this->load('company')->company->name,
            'notes' => $this->notes,
            'role' => $this->role,
            'stripe_id' => $this->stripe_id,
            'verified' => $this->verified,
            'subscriptions' => new SubscriptionCollection($this->subscriptions)
        ];
    }
}
