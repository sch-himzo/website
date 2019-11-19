<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignGroup extends Model
{
    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function getCover()
    {
        if($this->designs->count()==0){
            return null;
        }else{
            return $this->designs->random();
        }

    }

    public function hasPermission(User $user)
    {
        $perm = false;

        for($i = $this; $i!=null; $i= $i->parent){
            if($i->owner_id == $user->id){
                $perm = true;
            }
        }

        return $perm;
    }

    public function parent()
    {
        return $this->belongsTo(DesignGroup::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DesignGroup::class,'parent_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'owner_id');
    }
}
