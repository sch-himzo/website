<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    public function originalOrder()
    {
        return $this->belongsTo(Order::class,'original_order_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function group()
    {
        return $this->belongsTo(DesignGroup::class);
    }
}
