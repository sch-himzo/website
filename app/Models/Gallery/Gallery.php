<?php

namespace App\Models\Gallery;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['name','description','role_id'];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function images()
    {
        return $this->hasManyThrough(Image::class,Album::class,'gallery_id','album_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
