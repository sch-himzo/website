<?php

namespace App\Models\Order;

use App\Models\Comment;
use App\Models\Design;
use App\Models\DesignGroup;
use App\Models\Gallery\Album;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = "orders";

    protected $fillable = [
        'user_id','title','count','time_limit','type','internal','size','font','comment','existing_design'
    ];

    public function getStatusInternal()
    {
        if($this->archived){
            return "Archivált";
        }

        switch($this->status){
            case "0": return "Beérkezett";
            case "1": return "Tervezve";
            case "2": return "Próbahímzés kész";
            case "3": return "Hímezve";
            case "4": return "Fizetve";
            case "5": return "Átadva";
            default: return "Folyamatban";
        }
    }

    public function getStatusClient()
    {
        switch($this->status){
            case "0": return "Beérkezett";
            case "1": return "Tervezve";
            case "2": return "Próbahímzés kész";
            case "3": return "Hímezve";
            case "4": return "Fizetve";
            case "5": return "Átadva";
            default: return "Folyamatban";
        }
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class,'order_album','order_id','album_id');
    }

    public function design()
    {
        return $this->belongsTo(DesignGroup::class,'design_group_id');
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
                if($this->group->internal){
                    return 200;
                }else{
                    return 400;
                }
            }else{
                if($this->group->internal){
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
            if($this->group->internal){
                return 100;
            }else{
                return 200;
            }
        }elseif($dst->size>5 && $dst->size<=10){
            if($this->group->internal){
                return 200;
            }else{
                return 300;
            }
        }else{
            if($this->group->internal){
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
        if($this->group->internal){
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
                if($this->group->internal){
                    $sum += $color->stitch_count/25;
                }else{
                    $sum += $color->stitch_count/15;
                }
            }else{
                if($this->group->internal){
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


    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class,'order_group_id');
    }

    public function testAlbum()
    {
        return $this->belongsTo(Album::class, 'test_album_id');
    }
}
