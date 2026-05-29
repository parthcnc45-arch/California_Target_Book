<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewSubscriber
{

    use Dispatchable, SerializesModels;

    public $subscriber;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }
}
