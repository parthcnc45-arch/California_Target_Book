<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\SubscriptionMarkedPaid;

class SendSubscriptionMarkedPaid
{
    use Dispatchable;


    public $tries = 5;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SubscriptionMarkedPaid($this->user);
        Mail::to($this->user->email)->send($email);
    }
}
