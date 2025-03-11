<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const SEX = [
        'H' => 'Hombre',
        'M' => 'Mujer',
        'O' => 'Otro'
    ];

    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'sex',
        'date_of_birth',
        'phone_number',
        'password',
        'tokens',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'tokens' => 'integer',
    ];

    // Relación con los servicios
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Relación con las conversaciones donde el usuario es user1
    public function conversationsAsUser1()
    {
        return $this->hasMany(Conversation::class, 'user1_id');
    }

    // Relación con las conversaciones donde el usuario es user2
    public function conversationsAsUser2()
    {
        return $this->hasMany(Conversation::class, 'user2_id');
    }

    // Obtener todas las conversaciones del usuario
    public function conversations()
    {
        return Conversation::where('user1_id', $this->id)
            ->orWhere('user2_id', $this->id);
    }

    // Relación con los mensajes enviados
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Relación con los mensajes recibidos
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}