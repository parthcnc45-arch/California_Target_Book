<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable
{
    protected $admin;
    protected $message;
    protected $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->admin = $data['admin'];
        $this->message = $data['message'];
        $this->link = $data['link'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.admin-notification')
            ->with([
                'name' => $this->admin->first_name,
                'notification' => $this->message,
                'link' => $this->link,
            ]);
    }
}
