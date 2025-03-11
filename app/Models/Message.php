<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    // Relación con el remitente
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relación con el receptor
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Relación con la conversación
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}