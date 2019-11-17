<?php

namespace App\Models\Gallery;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'album_id','image','title','description','user_id'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function gallery()
    {
        return $this->hasManyThrough(Gallery::class,Album::class,null,null,'album_id','gallery_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
