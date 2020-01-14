<?php

namespace App\Models;

use App\Models\Gallery\Image;
use App\Models\Order\Group;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function orders()
    {
        return $this->hasMany(Group::class);
    }

    public function approvedOrders()
    {
        return $this->hasMany(Group::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function designGroups()
    {
        return $this->hasMany(DesignGroup::class,'owner_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function assignedOrders()
    {
        return $this->belongsToMany(Group::class,'user_order','user_id','order_group_id');
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function generateEmailToken()
    {
        if($this->email_token == null){
            $this->email_token = Str::random(60);
            $this->save();
        }

        return $this->email_token;
    }

    public function jumperTransactions()
    {
        return $this->hasMany(JumperTransaction::class);
    }
}
