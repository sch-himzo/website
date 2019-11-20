<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    public function originalOrder()
    {
        return $this->belongsTo(Order::class,'original_order_id');
    }

    public function group()
    {
        return $this->belongsTo(DesignGroup::class);
    }

    public function extension()
    {
        $extension = explode('.',$this->image);
        return strtolower($extension[sizeof($extension)-1]);
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
    }
}