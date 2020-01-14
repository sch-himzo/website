<?php

namespace App\Models\Log;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function data()
    {
        switch($this->type) {
            case 'order':
                return $this->hasOne(Order::class);
                break;
            case 'group':
                return $this->hasOne(Group::class);
                break;
            case 'design':
                return $this->hasOne(Design::class);
                break;
            default:
                return null;
                break;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
