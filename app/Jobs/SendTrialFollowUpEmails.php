<?php

namespace App\Jobs;

use App\Mail\TrialFollowUp;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTrialFollowUpEmails
{
    use Dispatchable;

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
        Subscription::where('frequency', 0)
            ->whereHas('cycles', function ($q) {
               $q->where('ends_on', Carbon::now()->subDay()->toDateString());
            })
            ->get()
            ->each(function ($sub) {
                $user = $sub->subscriber()
                    ->select(['email', 'first_name', 'last_name'])
                    ->first();
                Mail::to($user->email)->send(new TrialFollowUp($user));
            });
    }
}
