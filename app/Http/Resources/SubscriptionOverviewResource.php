<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SubscriptionOverviewResource extends Resource
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

        return [
            'id' => $this->id,
            'company' => $companyName,
            'baseAccount' => [
                'id' => $u->id,
                'email' => $u->email,
                'name' => $usersName,
            ],
            'isActive' => $this->isActive(),
            'cycle' => $this->getCurrentCycle(),
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
