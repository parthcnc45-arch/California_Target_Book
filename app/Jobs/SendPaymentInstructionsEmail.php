<?php

namespace App\Jobs;

use App\Subscription;
use App\User;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\PaymentInstructions;
use App\Mail\BankPaymentInstructions;

class SendPaymentInstructionsEmail
{
    use Dispatchable;

    public $tries = 5;

    protected $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $latestCycle = Subscription::where([ 'account_id' => $this->userId ])
            ->first()
            ->cycles()
            ->orderBy('created_at', 'desc')
            ->first();

        $user = User::find($this->userId);

        if ($latestCycle->payment_method === 'stripe-bank') {
            $email = new BankPaymentInstructions($user);
        } else {
            $email = new PaymentInstructions($user);
        }

        Mail::to($user->email)
            ->send($email);
    }
}
