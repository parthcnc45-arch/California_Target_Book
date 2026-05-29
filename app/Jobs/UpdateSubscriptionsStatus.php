<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Carbon\Carbon;
use App\Subscription;

/**
 * Check if subscriptions have expired,
 * and if so, update their status.
 */

class UpdateSubscriptionsStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Subscription::all()
            ->each(function ($sub) {
                $expired = Carbon::now()->gt(new Carbon($sub->ends_on));
                if ($expired) {
                    $sub->status = Subscription::STATUS_EXPIRED;
                    $sub->save();
                }
            });
    }
}
