<?php

namespace App\Models\Gallery;

use App\Models\Order;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['name','gallery_id','role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_album','album_id','order_id');
    }
}
