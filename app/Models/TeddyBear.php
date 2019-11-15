<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeddyBear extends Model
{
    protected $fillable = [
        'balance','name','description','role_id'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function calculateBalance()
    {
        $this->balance = 0;

        foreach($this->transactions as $transaction){
            if($transaction->in ==true){
                $this->balance += $transaction->amount;
            }else{
                $this->balance -= $transaction->amount;
            }
            $this->save();
        }

        return $this->balance;
    }
}
