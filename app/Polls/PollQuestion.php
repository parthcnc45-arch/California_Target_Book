<?php

namespace App\Polls;

use Illuminate\Database\Eloquent\Model;

class PollQuestion extends Model
{
    const RANGE = 'range';
    const MULTIPLE_CHOICE = 'multiple_choice';
    const OPEN = 'open';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'text',
    ];

    public function answerOptions() {
        return $this->hasMany('App\Polls\PollAnswerOption');
    }

    public function responses() {
        return $this->hasMany('App\Polls\PollResponse');
    }
}

PollQuestion::created(function ($q) {
    if ($q->type === PollQuestion::RANGE) {
        $q->answerOptions()->createMany([
            [ 'text' => 'Strongly Disagree' ],
            [ 'text' => 'Disagree' ],
            [ 'text' => 'Neutral' ],
            [ 'text' => 'Agree' ],
            [ 'text' => 'Strongly Agree' ],
        ]);
    }

});
