<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\PasswordReset;

class SendPasswordReset
{
    use Dispatchable;

    protected $user;
    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)
            ->send(new PasswordReset($this->user, $this->token));
    }
}
