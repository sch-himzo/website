<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Order\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function orderDeletedClient(Order $order, $reason)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }
        if($user==null){
            return;
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
            'time_limit' => $order->time_limit,
            'count' => $order->count,
            'types' => $types,
            'type' => $order->type,
            'size' => $order->size,
            'reason' => $reason
        ];

        if($order->font!=null){
            $data['font'] = $order->font;
        }

        if($order->comment!=null){
            $data['comment'] = $order->comment;
        }

        if(env('APP_DEBUG')!='true'){
            Mail::send('emails.deleted.client', $data, function($message) use ($to_name,$to_email,$order_title){
                $message->to($to_email,$to_name)
                    ->subject('Rendelés törölve ('.$order_title.')')
                    ->replyTo('himzo@sch.bme.hu');

                $message->from('himzobot@gmail.com','Pulcsi és Foltmékör');
            });
        }
    }

    public static function orderReceivedClient(Order $order)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }
        if($user==null){
            return;
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

        if(env('APP_DEBUG')!='true') {
            Mail::send('emails.received.client', $data, function ($message) use ($to_name, $to_email, $order_title) {
                $message->to($to_email, $to_name)
                    ->subject('Rendelés feldolgozva (' . $order_title . ')')
                    ->replyTo('himzo@sch.bme.hu');

                $message->from('himzobot@gmail.com', 'Pulcsi és Foltmékör');
            });
        }
    }

    public static function orderReceivedInternal(Order $order)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }
        if($user==null){
            return;
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

        if(env('APP_DEBUG')!='true'){
            Mail::send('emails.received.internal', $data, function($message) use ($to_name,$to_email,$order_title,$user_email){
                $message->to($to_email,$to_name)
                    ->subject('Rendelés beérkezett ('.$order_title.')')
                    ->replyTo('himzo@sch.bme.hu');

                $message->from('himzobot@gmail.com','Pulcsi és Foltmékör');
            });
        }

    }

    public static function orderApprovedClient(Group $order)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }
        if($user==null){
            return;
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

        if(env('APP_DEBUG')!='true') {
            Mail::send('emails.approved.client', $data, function ($message) use ($to_name, $to_email, $order_title) {
                $message->to($to_email, $to_name)
                    ->subject('Rendelés elfogadva (' . $order_title . ')')
                    ->replyTo('himzo@sch.bme.hu');

                $message->from('himzobot@gmail.com', 'Pulcsi és Foltmékör');
            });
        }
    }

    public static function orderApprovedInternal(Order $order, $approver)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }
        if($user==null){
            return;
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
            'size' => $order->size,
            'approver' => $approver
        ];

        if($order->font!=null){
            $data['font'] = $order->font;
        }

        if($order->comment!=null){
            $data['comment'] = $order->comment;
        }

        if(env('APP_DEBUG')!='true') {
            Mail::send('emails.approved.internal', $data, function ($message) use ($to_name, $to_email, $order_title, $user_email) {
                $message->to($to_email, $to_name)
                    ->subject('Rendelés beérkezett (' . $order_title . ')')
                    ->replyTo('himzo@sch.bme.hu');

                $message->from('himzobot@gmail.com', 'Pulcsi és Foltmékör');
            });
        }
    }

    public static function orderQuestion(Order $order, $message)
    {
        if($order->user==null){
            $user = $order->tempUser;
        }else{
            $user = $order->user;
        }
        if($user==null){
            return;
        }

        $types = [
            1 => 'Folt',
            3 => 'Pulcsira hímzendő',
            2 => 'Pólóra hímzendő'
        ];

        $to_name = $user->name;
        $to_email = $user->email;
        $from_name = Auth::user()->name;
        $from_email = Auth::user()->email;

        $order_title = $order->title;

        $data = [
            'name' => $to_name,
            'from_name' => $from_name,
            'message_a' => (string)($message),
            'title' => $order->title,
            'time_limit' => $order->time_limit,
            'count' => $order->count,
            'types' => $types,
            'type' => $order->type,
            'size' => $order->size
        ];

        if(!filter_var($to_email,FILTER_VALIDATE_EMAIL)){
            $to_email = "benedekb97@gmail.com";
        };

        if($order->image!=''){
            $data['image'] = route('orders.getImage', ['order' => $order]);
        }

        if($order->font!=null){
            $data['font'] = $order->font;
        }

        if($order->comment!=null){
            $data['comment'] = $order->comment;
        }


        if(env('APP_DEBUG')!='true') {
            Mail::send('emails.question', $data, function ($message) use ($to_name, $to_email, $order_title, $from_email, $from_name) {
                $message->to($to_email, $to_name)
                    ->subject('Rendeléssel kapcsolatos kérdés (' . $order_title . ')')
                    ->bcc($from_email)
                    ->bcc('himzo@sch.bme.hu')
                    ->replyTo('himzo@sch.bme.hu');

                $message->from($from_email, $from_name);
            });
        }
    }

    public static function registerEmail(User $user)
    {
        $data = [
            'user' => $user
        ];

        $to_name = $user->name;
        $to_email = $user->email;

        $from_name = "Pulcsi és Foltmékör";
        $from_email = "himzobot@gmail.com";

        Mail::send('emails.register', $data, function($message) use ($to_name, $to_email, $from_email, $from_name){
            $message->to($to_email, $to_name)
                ->subject('Felhasználó aktiválása');

            $message->from($from_email, $from_name);
        });
    }

    public static function sendPings()
    {
        Carbon::setLocale('hu');

        $threedays = date('Y-m-d H:i:s',time()+3*24*60*60);

        $orders = Group::all()
            ->where('time_limit','<',$threedays)
            ->where('archived',false)
            ->where('status','!=','5')
            ->where('status','!=','4')
            ->where('status','!=','3')
            ->all();

        if(env('APP_DEBUG')=='true'){
            return null;
        }

        foreach($orders as $order){
            $assigned_users = $order->assignedUsers;
            if($assigned_users!=null && $assigned_users->count()!=0){
                foreach($assigned_users as $user){
                    if($user->allow_emails == false){
                        continue;
                    }
                    $to_name = $user->name;
                    $to_email = $user->email;

                    $data = [
                        'user' => $user,
                        'assigned_users' => $assigned_users,
                        'group' => $order
                    ];

                    $order_name = $order->title;

                    $email = new Email();
                    $email->to = $to_email;
                    $email->subject = "";
                    $email->message = view('emails.ping', $data)->render();
                    $email->from = "Rendszeres ping";
                    $email->user_id = null;
                    $email->automated = true;
                    $email->save();

                    Mail::send('emails.ping', $data, function($message) use ($to_name,$to_email, $order_name){
                        $message->to($to_email,$to_name)
                            ->subject('Közelgő határidejű rendelés - '.$order_name);

                        $message->from('himzobot@gmail.com','Pulcsi és Foltmékör');
                    });
                }
            }
        }
    }
}
