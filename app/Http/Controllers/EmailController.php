<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function orderReceivedClient(Order $order)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }

        $types = [
            1 => 'Folt',
            3 => 'Pulcsira hímzendő',
            2 => 'Pólóra hímzendő'
        ];

        $to_name = $user->name;
        $to_email = $user->email;

        $order_title = $order->title;

        $data = [
            'name' => $to_name,
            'title' => $order->title,
            'image' => route('orders.getImage', ['order' => $order]),
            'time_limit' => $order->time_limit,
            'count' => $order->count,
            'types' => $types,
            'type' => $order->type,
            'size' => $order->size
        ];

        if($order->font!=null){
            $data['font'] = $order->font;
        }

        if($order->comment!=null){
            $data['comment'] = $order->comment;
        }

        Mail::send('emails.received.client', $data, function($message) use ($to_name,$to_email,$order_title){
            $message->to($to_email,$to_name)
                ->subject('Rendelés feldolgozva ('.$order_title.')');

            $message->from('himzobot@gmail.com','Pulcsi és Foltmékör');
        });
    }

    public static function orderReceivedHimzo(Order $order)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }

        $user_email = $user->email;
        $user_name = $user->name;

        $types = [
            1 => 'Folt',
            3 => 'Pulcsira hímzendő',
            2 => 'Pólóra hímzendő'
        ];

        $to_name = 'himzo@sch.bme.hu';
        $to_email = 'himzo@sch.bme.hu';

        $order_title = $order->title;

        $data = [
            'user_name' => $user_name,
            'user_email' => $user_email,
            'title' => $order->title,
            'image' => route('orders.getImage', ['order' => $order]),
            'time_limit' => $order->time_limit,
            'count' => $order->count,
            'types' => $types,
            'type' => $order->type,
            'size' => $order->size
        ];

        if($order->font!=null){
            $data['font'] = $order->font;
        }

        if($order->comment!=null){
            $data['comment'] = $order->comment;
        }

//        Mail::send('emails.received.internal', $data, function($message) use ($to_name,$to_email,$order_title,$user_email){
//            $message->to($to_email,$to_name)
//                ->subject('Rendelés beérkezett ('.$order_title.')')
//                ->replyTo($user_email);
//
//            $message->from('himzobot@gmail.com','Pulcsi és Foltmékör');
//        });

        Mail::send('emails.received.internal', $data, function($message) use ($order_title,$user_email){
            $message->to(Auth::user()->email,Auth::user()->name)
                ->subject('Rendelés beérkezett ('.$order_title.')');

            $message->from('himzobot@gmail.com','Pulcsi és Foltmékör');
        });
    }
}
