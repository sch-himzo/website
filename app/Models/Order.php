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

    public function getStatusClient()
    {
        $checklist = $this->trelloCard->getChecklist()[0];

        $items = $checklist->checkItems;

        if($this->approved_by == null){
            return "Elfogadásra vár";
        }

        if($items[0]->name =="tervezve" && $items[0]->state=="complete"){
            if($items[1]->name == "hímezve" && $items[1]->state=="complete"){
                if($items[2]->name == "fizetve" && $items[2]->state == "complete"){
                    if($items[3]->name == "átadva" && $items[3]->state == "complete"){
                        return "Fizetve";
                    }else{
                        return "Átadásra vár";
                    }
                }else{
                    return "Fizetésre vár";
                }
            }else{
                return "Folyamatban";
            }
        }else{
            return "Folyamatban";
        }


    }
}
