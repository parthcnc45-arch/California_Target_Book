<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AddonInvitation extends Mailable
{
    protected $baseUser;
    protected $addonUser;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($baseUser, $addonUser)
    {
        $this->baseUser = $baseUser;
        $this->addonUser = $addonUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.addon-invitation')->with([
            'baseUserName' => $this->baseUser->name(),
            'baseUserEmail' => $this->baseUser->email,
            'company_name' => $this->baseUser->company()->first()->name,
            'email_token' => $this->addonUser->email_token
        ]);
    }
}
