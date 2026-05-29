<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Jobs\SendInvoice;

\Stripe\Stripe::setApiKey(env("STRIPE_KEY"));

class SendInvoiceEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:send-invoice ${invoiceId} ${email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an Invoice to a given email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	$user = User::where('email', $this->argument('email'))->first();
	$invoice = \Stripe\Invoice::retrieve($this->argument('invoiceId'));

	dispatch(new SendInvoice($user, $invoice));
    }
}
