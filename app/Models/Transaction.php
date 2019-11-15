<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount','user_id','teddy_bear_id','for','in'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teddyBear()
    {
        return $this->belongsTo(TeddyBear::class);
    }
}
