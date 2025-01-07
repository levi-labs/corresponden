<?php

namespace App\Events;

use App\Models\OutgoingLetter;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OutgoingLetterCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $outgoingLetter;
    /**
     * Create a new event instance.
     */
    public function __construct(OutgoingLetter $outgoingLetter)
    {
        $this->outgoingLetter = $outgoingLetter;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
