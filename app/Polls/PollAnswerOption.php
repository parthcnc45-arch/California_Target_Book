<?php

namespace App\Polls;

use Illuminate\Database\Eloquent\Model;

class PollAnswerOption extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'text',
    ];

}
