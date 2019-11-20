<?php

namespace App\Models;

use App\Models\Gallery\Album;
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

    public function updateStatus()
    {
        $this->status = $this->getStatus();
        $this->save();
    }

    public function getStatus()
    {
        $checklists = $this->trelloCard->getChecklist();

        if(sizeof($checklists)<1){
            if($this->approved_by==null){
                return "arrived";
            }else{
                return "approved";
            }
        }

        $checklist = $checklists[0];

        $items = $checklist->checkItems;

        if($this->approved_by==null){
            return "arrived";
        }

        if($items[0]->name =="tervezve" && $items[0]->state=="complete"){
            if($items[1]->name == "hímezve" && $items[1]->state=="complete"){
                if($items[2]->name == "fizetve" && $items[2]->state == "complete"){
                    if($items[3]->name == "átadva" && $items[3]->state == "complete"){
                        return "finished";
                    }else{
                        return "payed";
                    }
                }else{
                    return "embroidered";
                }
            }else{
                return "designed";
            }
        }else{
            return "approved";
        }
    }

    public function getStatusInternal()
    {
        if($this->archived){
            return "Archivált";
        }

        switch($this->status){
            case "arrived": return "Elfogadásra vár";
            case "approved": return "Elfogadva";
            case "payed": return "Fizetve";
            case "embroidered": return "Hímezve";
            case "designed" : return "Tervezve";
            case "finished": return "Kész";
            default: return "Folyamatban";
        }
    }

    public function getStatusClient()
    {
        switch($this->status){
            case "arrived": return "Elfogadásra vár";
            case "approved": return "Folyamatban";
            case "payed": return "Átadásra vár";
            case "embroidered": return "Fizetésre vár";
            case "designed": return "Folyamatban";
            case "finished": return "Átadva";
            default: return "Folyamatban";
        }
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class,'order_album','order_id','album_id');
    }

    public function design()
    {
        return $this->belongsTo(DesignGroup::class,'design_id');
    }
}
