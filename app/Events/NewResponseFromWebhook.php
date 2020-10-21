<?php

namespace App\Events;

use App\Response;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewResponseFromWebhook
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

}
