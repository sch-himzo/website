<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    //

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}