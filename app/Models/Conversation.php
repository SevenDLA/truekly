<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = [];

    // Relación con el usuario user1
    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    // Relación con el usuario user2
    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    // Relación con los mensajes
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}