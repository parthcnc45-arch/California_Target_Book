<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'stripe_charge_id',
        'stripe_invoice_id',
        'description',
        'plan',
        'amount',
        'amount_refunded',
        'status',
        'payment_method',
        'invoice_url',
        'raw_stripe_data',
        'transaction_date'
    ];

    protected $casts = [
        'raw_stripe_data' => 'array',
        'transaction_date' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function subscription() {
        return $this->belongsTo('App\Subscription');
    }
}
