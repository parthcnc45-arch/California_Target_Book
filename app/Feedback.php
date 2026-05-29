<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Subscriber given feedback
 */

class Feedback extends Model
{

    protected $fillable = [
        'feedback',
        'user_id',
        'tracker_session',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
