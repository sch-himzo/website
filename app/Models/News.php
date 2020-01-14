<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
