<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrelloCard extends Model
{
    public function trelloList()
    {
        return $this->belongsTo(TrelloList::class,'list_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class,'trello_card');
    }

    public function getChecklist(){
        $card = $this->trello_id;
        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');

        $url = "https://api.trello.com/1/cards/$card/checklists?key=$key&token=$token";

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output = json_decode(curl_exec($ch));

        return $output;
    }
}
