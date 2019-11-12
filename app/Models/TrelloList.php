<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrelloList extends Model
{
    protected $fillable = [
        'trello_id','name'
    ];

    public function trelloCards()
    {
        return $this->hasMany(TrelloCard::class);
    }

    public function getTrelloId()
    {
        return $this->trello_id;
    }
}
