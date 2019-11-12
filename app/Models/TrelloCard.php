<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrelloCard extends Model
{
    public function trelloList()
    {
        return $this->belongsTo(TrelloList::class);
    }
}
