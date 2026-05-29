<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SetPassword extends Mailable
{

    protected $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.set-password')
            ->with([
                'name' => $this->user->name(),
                'email' => $this->user->email,
                'token' => $this->token,
            ]);
    }
}
