<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

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

    //Relación con las compras como comprador
    public function purchases()
    {
        return $this->hasMany(Compra::class, 'user_buyer_id');
    }

    //Relación con las compras como vendedor
    public function sales()
    {
        return $this->hasMany(Compra::class, 'user_seller_id');
    }

}