<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrelloCard;
use App\Models\TrelloList;
use Illuminate\Http\Request;

class TrelloController extends Controller
{
    public function lists()
    {
        $c = curl_init();

        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');
        $board = env('TRELLO_BOARD');

        $url = "https://api.trello.com/1/board/$board/lists?cards=none&key=$key&token=$token";

        curl_setopt($c, CURLOPT_URL,$url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER,true);

        $output = json_decode(curl_exec($c));

        if($output==null){
            abort(500);
        }

        foreach($output as $list){
            if(TrelloList::all()->where('trello_id',$list->id)->count()>0){
                $old_list = TrelloList::all()->where('trello_id',$list->id)->first();

                $old_list->name = $list->name;
                $old_list->save();
            }else{

                $new_list = new TrelloList();

                $new_list->name = $list->name;
                $new_list->trello_id = $list->id;
                $new_list->save();

            }
        }

        dd($output);
    }

    public function checklist($checklist_id)
    {
        $c = curl_init();

        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');

        $url = "https://api.trello.com/1/checklists/$checklist_id?key=$key&token=$token";

        curl_setopt($c,CURLOPT_URL,$url);
        curl_setopt($c,CURLOPT_RETURNTRANSFER,true);

        $output = json_decode(curl_exec($c));

        $return = [];

        if($output->name=="Teendők"){
            foreach($output->checkItems as $item){
                $return[$item->name] = $item->state=="complete";
            }

            $status = "none";

            foreach($return as $key => $complete){
                if($complete){
                    $status = $key;
                }
            }

            return $status;
        }else{
            return null;
        }
    }

    public function cards(TrelloList $trello_list)
    {
        $c = curl_init();

        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');

        $url = "https://api.trello.com/1/lists/$trello_list->trello_id/cards?key=$key&token=$token";

        curl_setopt($c, CURLOPT_URL,$url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER,true);

        $output = json_decode(curl_exec($c));

        foreach($output as $card){
            if($card->idChecklists != null) {
                foreach($card->idChecklists as $checklist){
                    $completeness = $this->checklist($checklist);
                }
            }else{
                $completeness = null;
            }

            $old_card = TrelloCard::all()->where('trello_id',$card->id)->first();

            $idLabels = "";
            if($card->labels!=null){
                foreach($card->labels as $label){
                    $idLabels .= $label->id.",";
                }
            }else{
                $idLabels = "";
            }

            if($old_card!=null){
                $old_card->name = $card->name;
                $old_card->desc = $card->desc;
                $old_card->status = $completeness;
                $old_card->idLabels = $idLabels;
                $old_card->list_id = $trello_list->id;
                $old_card->save();
            }else{
                $new_card = new TrelloCard();
                $new_card->name = $card->name;
                $new_card->trello_id = $card->id;
                $new_card->desc = $card->desc;
                $new_card->status = $completeness;
                $new_card->idLabels = $idLabels;
                $new_card->list_id = $trello_list->id;
                $new_card->save();
            }

        }

        dd($output);
    }
}
