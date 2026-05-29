<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookSubscription extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'subscription_id',
        'address_id',
    ];

    protected $dates = ['deleted_at'];

    public function subscription() {
        return $this->belongsTo('App\Subscription');
    }
    public function address() {
        return $this->belongsTo('App\Address');
    }
}
