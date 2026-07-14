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
        'user_id',
        'address_id',
        'carrier',
        'tracking_id',
        'tracking_url',
        'estimated_delivery',
        'status',
        'ship_date',
        'item_name'
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->order_id)) {
                $year = date('Y');
                $prefix = "TB-{$year}-";
                
                // Find the latest order_id for the current year
                $lastOrder = static::where('order_id', 'like', "{$prefix}%")
                                   ->orderBy('id', 'desc')
                                   ->first();
                                   
                $nextNumber = 1;
                if ($lastOrder && $lastOrder->order_id) {
                    $parts = explode('-', $lastOrder->order_id);
                    if (count($parts) === 3) {
                        $nextNumber = intval($parts[2]) + 1;
                    }
                }
                
                $model->order_id = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function subscription() {
        return $this->belongsTo('App\Subscription');
    }
    public function address() {
        return $this->belongsTo('App\Address');
    }
}
