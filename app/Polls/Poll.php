<?php

namespace App\Polls;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'title',
        'starts_on',
        'ends_on',
    ];

    static public function getCurrentPoll() {
        return self::where('starts_on', '<=', Carbon::now()->addDay())
            ->where('ends_on', '>=', Carbon::now()->subDay())
            ->with(['questions.answerOptions'])
            ->first();
    }

    public function questions() {
        return $this->hasMany('App\Polls\PollQuestion');
    }

    public function dateDisplay() {
        return (new Carbon($this->starts_on))->toFormattedDateString();
    }
}
