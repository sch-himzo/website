<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function design()
    {
        return $this->belongsTo(Design::class);
    }
}
