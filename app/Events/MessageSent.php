<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Message;

class MessageSent implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets;

    public $message;

    public function __construct(Message $message) {
        $this->message = $message->load('sender');
    }

    public function broadcastOn() {
        return new PrivateChannel('conversation.'.$this->message->conversation_id);
    }

    public function broadcastWith() {
        return [
            'message' => $this->message,
            'html' => view('partials.message', ['message' => $this->message])->render()
        ];
    }
}