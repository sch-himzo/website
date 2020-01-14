<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumperTransaction extends Model
{
    public function type()
    {
        return $this->belongsTo(JumperType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tempUser()
    {
        return $this->belongsTo(TempUser::class);
    }
}
