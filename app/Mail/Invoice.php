<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class Invoice extends Mailable
{

    protected $user;
    protected $invoiceNumber;
    protected $line_items;
    protected $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $invoiceNumber, $line_items, $total)
    {
        $this->user = $user;
        $this->invoiceNumber = $invoiceNumber;
        $this->line_items = $line_items;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.invoice')
            ->with([
                'name' => $this->user->name(),
                'invoiceNumber' => $this->invoiceNumber,
                'line_items' => $this->line_items,
                'total' => $this->total,
            ]);
    }
}
