<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','title','count','time_limit','type','internal','size','font','comment'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tempUser()
    {
        return $this->belongsTo(TempUser::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function trelloCard()
    {
        return $this->belongsTo(TrelloCard::class,'trello_card');
    }
}