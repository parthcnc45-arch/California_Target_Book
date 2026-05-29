<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class EmailVerification extends Mailable
{
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.verification')->with([
            'name' => $this->user->name(),
            'email_token' => $this->user->email_token,
        ]);
    }
}
