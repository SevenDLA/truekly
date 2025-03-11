<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Conversation;

class MessageList extends Component {
    public $conversations;

    public function mount() {
        $this->conversations = auth()->user()->conversations()
            ->with(['user1', 'user2', 'messages' => fn($q) => $q->latest()])
            ->get()
            ->sortByDesc(function($conv) {
                return $conv->messages->latest()->first()->created_at ?? $conv->created_at;
            });
    }

    public function render() {
        return view('livewire.message-list');
    }
}