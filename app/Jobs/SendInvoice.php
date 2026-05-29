<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\Invoice;

class SendInvoice
{
    use Dispatchable;

    protected $user;
    protected $invoiceNumber;
    protected $line_items;
    protected $total;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $invoice)
    {
        $this->user = $user;
        $this->invoiceNumber = $invoice->id;
        $this->line_items = array_reverse($invoice->lines->all()->data);
        $this->total = $invoice->amount_due;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Invoice($this->user, $this->invoiceNumber, $this->line_items, $this->total);
        Mail::to($this->user->email)->send($email);
    }
}
