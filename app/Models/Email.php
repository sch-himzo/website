<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'to','subject','message','from','user_id','automated'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
