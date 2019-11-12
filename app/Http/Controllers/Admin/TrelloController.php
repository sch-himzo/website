<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TempUser;
use App\Models\TrelloCard;
use App\Models\TrelloList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public static function checklist($checklist_id)
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

    public static function updateCards(TrelloList $trello_list)
    {
        $c = curl_init();

        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');

        $url = "https://api.trello.com/1/lists/$trello_list->trello_id/cards?key=$key&token=$token";

        curl_setopt($c, CURLOPT_URL,$url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER,true);

        $output = json_decode(curl_exec($c));

        foreach($output as $card){

            $last_activity = strtotime($card->dateLastActivity);

            $old_card = TrelloCard::all()->where('trello_id',$card->id)->first();

            if($old_card != null){
                $stored_activity = strtotime($old_card->updated_at);

                if($last_activity<$stored_activity){
                    continue;
                }
            }

            if($card->idChecklists != null) {
                foreach($card->idChecklists as $checklist){
                    $completeness = static::checklist($checklist);
                }
            }else{
                $completeness = null;
            }

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

                $matches = [];

                preg_match("/-.\*\*Darabszám:\*\* ([0-9]*)/",$card->desc,$matches);

                if(sizeof($matches)>0){
                    $count = (int)($matches[1]);
                }else{
                    $count = 0;
                }


                $matches = [];

                if(sizeof($matches)>0){
                    $temp_user = new TempUser();
                    $name = $matches[1];
                    $email = $matches[2];

                    $temp_user->name = $name;
                    $temp_user->email = $email;
                    $temp_user->save;
                }

                preg_match("/- \*\*Rendelő:\*\*.(.*) - (.*)/", $card->desc, $matches);



                $order = new Order();
                if(isset($temp_user)){
                    $order->temp_user_id = $temp_user->id;
                }
                $order->user_id = null;
                $order->title = $card->name;
                $order->count = $count;
                $order->time_limit = null;
                $order->type = 1;
                $order->internal = true;
                $order->size = 0;
                $order->image = "";
                $order->trello_card = $new_card->id;
                $order->approved_by = Auth::id();
                $order->save();
            }

        }
    }

    public function cards(TrelloList $trello_list)
    {
        static::updateCards($trello_list);
    }
}
