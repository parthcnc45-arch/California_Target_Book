<?php

namespace App\Jobs;

use App\Mail\AdminMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessageFrom
{
    use Dispatchable;

    protected $email;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($toEmail, $data) {
        $this->email = $toEmail;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::send('email.admin-message', ['body' => $this->data['message']], function ($message) {
            $message->to($this->email)
                ->from($this->data['from_email'], $this->data['from_name'])
                ->replyTo($this->data['from_email'], $this->data['from_name'])
                ->sender($this->data['from_email'], $this->data['from_name'])
                ->subject($this->data['subject']);
        });
    }
}
