<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classified;

class ClassifiedReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $classified;
    public $charge;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Classified $classified, $charge)
    {
        $this->classified = $classified;
        $this->charge = $charge;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Payment Receipt: California Target Book Classified Ad')
                    ->view('email.classified_receipt');
    }
}
