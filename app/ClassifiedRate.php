<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassifiedRate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classified_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'rate',
        'rate_amount',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rate_amount' => 'float',
    ];
}
