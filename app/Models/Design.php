<?php

namespace App\Models;

use App\Models\Order\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Design extends Model
{
    use SoftDeletes;

    public function originalOrder()
    {
        return $this->belongsTo(Group::class,'original_order_id');
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

    public function background()
    {
        return $this->belongsTo(Background::class);
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
