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
}