<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_seller_id');
    }
}
