<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FeedbackPosted
{
    use Dispatchable, SerializesModels;

    public $feedback;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }
}
