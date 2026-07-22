<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassifiedRate extends Model
{
    use HasFactory;

    protected $table = 'classified_rates';

    protected $fillable = [
        'title',
        'rate_amount',
        'days',
        'status',
    ];
}
