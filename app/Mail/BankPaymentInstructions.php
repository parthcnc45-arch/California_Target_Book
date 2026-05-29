<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class BankPaymentInstructions extends Mailable
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
        return $this->view('email.bank-payment-instructions')
            ->with([
                'name' => $this->user->name(),
                'email' => $this->user->email,
            ]);
    }
}
