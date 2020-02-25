<?php

namespace App\Models\Order;

use App\Models\Comment;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $table = "order_groups";

    public function comments()
    {
        return $this->hasMany(Comment::class,'order_group_id');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class,'user_order','order_group_id','user_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class,'approved_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tempUser()
    {
        return $this->belongsTo(TempUser::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'order_group_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function getStatusInternal()
    {
        if($this->archived){
            return "Archivált";
        }

        switch($this->status){
            case "0": return "Elfogadásra vár";
            case "1": return "Elfogadva";
            case "2" : return "Tervezve";
            case "3": return "Hímezve";
            case "4": return "Fizetve";
            case "5": return "Kész";
            default: return "Folyamatban";
        }
    }

    public function getStatusClient()
    {
        switch($this->status){
            case "0": return "Elfogadásra vár";
            case "2": return "Átadásra vár";
            case "3": return "Fizetésre vár";
            case "5": return "Átadva";
            default: return "Folyamatban";
        }
    }

    public function getTotalCost()
    {
        if($this->status<2){
            return null;
        }
        $cost = 0;

        foreach($this->orders as $order)
        {
            $cost+=$order->getTotalCost();
        }

        return $cost;
    }
}
