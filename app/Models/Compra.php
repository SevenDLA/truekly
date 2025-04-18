<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    //
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_seller_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }




    const ESTADO = 
    [
        'P' => 'EN PROCESO',
        'T' => 'TERMINADO'
    ];



    protected $fillable = [
        'user_buyer_id',
        'user_seller_id',
        'service_id',
        'status'
    ];

}
