<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classified extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classifieds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'category',
        'organization_name',
        'title',
        'body',
        'link_url',
        'starts_on',
        'ends_on',
        'advertiser_email',
        'rate',
        'rate_amount',
        'classified_rate_id',
        'admin_notes',
        'payment_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'starts_on' => 'date:Y-m-d',
        'ends_on' => 'date:Y-m-d',
        'rate_amount' => 'float',
        'classified_rate_id' => 'integer',
    ];

    /**
     * Get the associated pre-defined rate option for this ad.
     */
    public function rateOption()
    {
        return $this->belongsTo(ClassifiedRate::class, 'classified_rate_id');
    }
}
