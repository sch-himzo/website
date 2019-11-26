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

    public function getDST()
    {
        $designs = $this->design;
        if($designs==null){
            return null;
        }

        $designs = $designs->designs;
        if($designs==null || $designs->count()==0){
            return null;
        }

        foreach($designs as $design){
            if($design->extension()=="dst"){
                return $design;
            }
        }
        return null;
    }

    public function getDesignCost()
    {
        if(!$this->original){
            return 0;
        }else{
            if($this->count>10){
                if($this->internal){
                    return 200;
                }else{
                    return 400;
                }
            }else{
                if($this->internal){
                    return 0;
                }else{
                    return 200;
                }
            }
        }
    }

    public function getBasePrice()
    {
        $dst = $this->getDST();
        if($dst==null){
            return null;
        }

        if($dst->size<=5){
            if($this->internal){
                return 100;
            }else{
                return 200;
            }
        }elseif($dst->size>5 && $dst->size<=10){
            if($this->internal){
                return 200;
            }else{
                return 300;
            }
        }else{
            if($this->internal){
                return 300;
            }else{
                return 400;
            }
        }
    }

    public function getJumperCost()
    {
        if($this->type==1){
            return 0;
        }
        if($this->internal){
            return 300;
        }else{
            return 400;
        }
    }

    public function getEmbroideryCost()
    {
        $dst = $this->getDST();
        if($dst==null){
            return null;
        }
        $colors = $dst->colors;

        if($colors==null || $colors->count()==0){
            return null;
        }

        $sum = 0;

        foreach($colors as $color){
            if($color->fancy){
                if($this->internal){
                    $sum += $color->stitch_count/25;
                }else{
                    $sum += $color->stitch_count/15;
                }
            }else{
                if($this->internal){
                    $sum += $color->stitch_count/100;
                }else{
                    $sum += $color->stitch_count/50;
                }
            }
        }

        return $sum;
    }

    public function getTotalCost()
    {
        if($this->getCost()==null){
            return null;
        }

        return round($this->getDesignCost() + $this->count * $this->getCost()-1);
    }

    public function getCost()
    {
        if($this->getEmbroideryCost()==null){
            return null;
        }

        return $this->getEmbroideryCost() + $this->getBasePrice() + $this->getJumperCost();
    }

    public function originalDesign()
    {
        return $this->hasOne(Design::class,'original_order_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class,'user_order','order_id','user_id');
    }
}
