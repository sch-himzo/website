<?php

namespace App\Models;

use App\Models\Gallery\Album;
use App\Models\Gallery\Gallery;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function teddyBears()
    {
        return $this->hasMany(TeddyBear::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
