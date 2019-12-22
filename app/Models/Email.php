<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Email extends Model
{
    protected $fillable = [
        'to','subject','message','from','user_id','automated'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function send()
    {
        if($this->send==false){
            return;
        }

        $to = $this->to;
        $from = $this->from;
        $to_name = $this->to_name;
        $from_name = $this->from_name;
        $subject = $this->subject;


        Mail::raw($this->message, function($message) use ($to, $to_name, $from, $from_name, $subject){
            $message->to($to, $to_name)
                ->subject($subject);
            $message->from($from, $from_name);
        });

        $this->sent_at = date("Y-m-d H:i:s",time());
        $this->save();

        return;
    }
}
