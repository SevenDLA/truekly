<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['user_seller_id', 'tokens', 'price', 'status'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_seller_id');
    }
}