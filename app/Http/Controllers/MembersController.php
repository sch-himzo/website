<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MembersController extends Controller
{
    public function index()
    {
        Carbon::setLocale('hu');

        Session::put('return_to','members.index');

        $oneweek = date('Y-m-d',time()+7*24*60*60);

        $oneweekminus = date('Y-m-d H:i:s', time()-7*24*60*60);

        $time_limit = Order::where('time_limit','<',$oneweek)
            ->where('archived',0)
            ->where('status','!=','finished')
            ->withCount('assignedUsers')
            ->get();

        $recent = Order::where('updated_at', '>', $oneweekminus)
            ->where('status','finished')
            ->withCount('assignedUsers')
            ->get();

        $ready = Order::where('status','payed')->orWhere('status','embroidered')->get();

        return view('members.index',[
            'time_limit' => $time_limit,
            'recent' => $recent,
            'ready' => $ready
        ]);
    }

    public function mine()
    {

        Session::put('return_to','members.mine');

        Carbon::setLocale('hu');
        $orders = Auth::user()
            ->assignedOrders
            ->where('archived',0)
            ->where('joint',0);

        $archived = Auth::user()
            ->assignedOrders
            ->where('archived',1);

        return view('members.mine', [
            'orders' => $orders,
            'archived' => $archived
        ]);
    }

    public function unapproved()
    {
        Session::put('return_to','members.unapproved');

        $orders = Order::where('approved_by',null)->where('archived',0)->get();

        return view('members.unapproved', [
            'orders' => $orders
        ]);
    }

    public function unassigned()
    {
        Session::put('return_to','members.unassigned');

        Carbon::setLocale('hu');

        $orders = [];
        $all_orders = Order::all()->where('archived',0)->sortByDesc('id')->all();
        foreach($all_orders as $order){
            if($order->assignedUsers->count()==0 && $order->joint==false){
                $orders[] = $order;
            }
        }

        return view('members.unassigned', [
            'orders' => $orders
        ]);
    }

    public function joint()
    {
        Session::put('return_to','members.joint');

        Carbon::setLocale('hu');

        $orders = Order::all()
            ->where('joint',true)
            ->where('archived',false)
            ->sortByDesc('id')
            ->all();

        return view('members.joint', [
            'orders' => $orders
        ]);
    }

    public function active()
    {
        Session::put('return_to','members.active');

        Carbon::setLocale('hu');

        $orders = Order::withCount('assignedUsers')->where('archived',false)->get()->sortByDesc('id');

        return view('members.active', [
            'orders' => $orders
        ]);
    }

    public function archived()
    {
        Session::put('return_to','members.archived');

        Carbon::setLocale('hu');

        $orders = Order::withCount('assignedUsers')->where('archived',true)->get()->sortByDesc('id');

        return view('members.archived', [
            'orders' => $orders
        ]);
    }
}
