<?php

namespace App\Polls;

use Illuminate\Database\Eloquent\Model;

class PollResponse extends Model
{
    protected $fillable = [
        'poll_answer_option_id',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
