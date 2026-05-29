<?php

namespace App\Jobs;

use App\Mail\AdminNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAdminNotification
{
    use Dispatchable;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new AdminNotification($this->data);
        Mail::to($this->data['admin']['email'])->send($email);
    }
}
