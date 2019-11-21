<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    public function designs()
    {
        return $this->hasMany(Design::class);
    }
}
