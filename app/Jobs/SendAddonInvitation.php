<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\AddonInvitation;

class SendAddonInvitation
{
    use Dispatchable;

    public $baseUser;
    public $addonUser;

    public function __construct($baseUser, $addonUser)
    {
        $this->baseUser = $baseUser;
        $this->addonUser = $addonUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new AddonInvitation($this->baseUser, $this->addonUser);
        Mail::to($this->addonUser->email)->send($email);
    }
}
