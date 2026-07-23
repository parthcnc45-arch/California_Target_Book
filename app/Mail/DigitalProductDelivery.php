<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DigitalProductDelivery extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $itemName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $itemName)
    {
        $this->user = $user;
        $this->itemName = $itemName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your California Target Book Digital Product: " . $this->itemName)
                    ->view('email.digital_product_delivery');
    }
}
