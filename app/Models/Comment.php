<?php

namespace App\Models;

use App\Models\Order\Group;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function order()
    {
        return $this->belongsTo(Group::class,'order_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
