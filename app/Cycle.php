<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cycle extends Model
{
    protected $fillable = [
        'starts_on',
        'ends_on',
        'payment_method',
        'invoice_id',
        'subscription_id',
    ];

    public function subscription() {
        return $this->belongsTo('App\Subscription');
    }

    public function activate() {
        $sub = $this->subscription()->first();

        if (empty($this->starts_on)) {
            $this->starts_on = Carbon::now();
        }

        if ($sub->frequency === 0) { // is a trial
            $this->ends_on = (new Carbon($this->starts_on))->addWeek();
        } else {
            $this->ends_on = (new Carbon($this->starts_on))->addMonths($sub->frequency);
        }

        $this->save();
    }

    public function isCurrent() {
        if (empty($this->starts_on) || empty($this->ends_on)) return false;
        // $start_on = new Carbon($this->starts_on);
        // $end_on = new Carbon($this->ends_on);
        // return Carbon::now()->between($start_on, $end_on, true);
        $start_on = Carbon::createFromFormat('Y-m-d', $this->starts_on)->startOfDay();
        $end_on = Carbon::createFromFormat('Y-m-d', $this->ends_on)->endOfDay();
        $now = Carbon::now();
    
        return $now->between($start_on, $end_on, true);
    }

    public function isPending() {
        return empty($this->starts_on);
    }

}
