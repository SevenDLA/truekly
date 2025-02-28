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
         'H' => 'Hombre'
        ,'M' => 'Mujer'
        ,'O' => 'Otro'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname', // Agregamos 'surname'
        'username', // Agregamos 'username'
        'email',
        'sex', // Agregamos 'sex'
        'date_of_birth', // Agregamos 'date_of_birth'
        'phone_number', // Agregamos 'phone_number'
        'password',
        'tokens', // Agregamos 'tokens'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date', // Convertimos 'date_of_birth' a un tipo de fecha
        'tokens' => 'integer', // Convertimos 'tokens' a tipo entero
    ];

    /**
     * The attributes that should be protected from mass-assignment.
     *
     * @var list<string>
     */
    // Si es necesario, puedes agregar un array $guarded en caso de que haya otros campos que no se puedan asignar masivamente
    // protected $guarded = ['id']; 

    public function services()
{
    return $this->hasMany(Service::class);
}


}
