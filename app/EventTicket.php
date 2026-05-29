<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    protected $fillable = [
        'buyer_id',
        'holders_name',
        'event',
        'invoice_id',
        'is_paid_for',
        'checked_in_at',
    ];

    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id');
    }

}
