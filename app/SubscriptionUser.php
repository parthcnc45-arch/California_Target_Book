<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SubscriptionUser extends Pivot
{

    const ADDON = 'addon';
    const SUBSCRIBER = 'subscriber';

    public $timestamps = false;

    protected $fillable = [
        'subscription_id',
        'user_id',
        'role',
    ];

    protected $attributes = [
        'role' => self::ADDON,
    ];
}
