<?php

namespace App\Models;

use App\Models\Order\Group;
use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    //

    public function orders()
    {
        return $this->hasMany(Group::class,'temp_user_id');
    }
}
