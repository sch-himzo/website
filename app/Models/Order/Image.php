<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = "order_images";

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getImage()
    {
        $path = 'storage/images/real/' . $this->image;
        return $path;
    }

    public function getThumbnail()
    {
        $path = 'storage/images/thumbnails/' . $this->image;
        return $path;
    }
}
