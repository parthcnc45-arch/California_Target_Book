<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\EmailVerification;
use App\User;

class SendVerificationEmail
{
    use Dispatchable;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $u = User::find($this->userId);
        Mail::to($u->email)->send(new EmailVerification($u));
    }
}
