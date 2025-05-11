<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    const CATEGORY = [
        'MUS' => 'Música',
        'GAM' => 'Gaming',
        'DEP' => 'Deporte',
        'ART' => 'Arte',
        'CIN' => 'Cine',
        'TEC' => 'Tecnología'
    ];

    const CONTACT = [
        'P' => 'Teléfono',
        'E' => 'Email',
        'T' => 'Teléfono'
    ];

    // In Service.php model
    public function compras()
    {
        return $this->hasMany(Compra::class, 'service_id');
    }

}
