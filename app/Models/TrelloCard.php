<?php

namespace App\Models;

use App\Models\Gallery\Album;
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

    public function addAlbum(Album $album)
    {
        $this->desc .= "
- ** Képek: ".route('albums.view',['album' => $album])." **";
        $this->save();

        $this->saveToTrello();
    }

    public function saveToTrello()
    {
        $data = [
            'desc' => $this->desc
        ];

        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');

        $url = "https://api.trello.com/1/cards/$this->trello_id?key=$key&token=$token";

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

        $output = json_decode(curl_exec($ch));
    }
}
