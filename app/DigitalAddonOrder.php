<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DigitalAddonOrder extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'item_name',
        'amount',
        'payment_status',
        'delivery_status'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function transaction() {
        return $this->belongsTo('App\Transaction');
    }
}
