<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

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
