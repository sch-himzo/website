<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
{
    public function index()
    {
        Carbon::setLocale('hu');

        $oneweek = date('Y-m-d',time()+7*24*60*60);

        $oneweekminus = date('Y-m-d H:i:s', time()-7*24*60*60);

        $time_limit = Order::where('time_limit','<',$oneweek)
            ->where('archived',false)
            ->where('status','!=','finished')
            ->withCount('assignedUsers')
            ->get();

        $recent = Order::where('updated_at', '>', $oneweekminus)
            ->where('status','finished')
            ->withCount('assignedUsers')
            ->get();

        return view('members.index',[
            'time_limit' => $time_limit,
            'recent' => $recent
        ]);
    }

    public function mine()
    {

        Carbon::setLocale('hu');
        $orders = Auth::user()->assignedOrders;

        return view('members.mine', [
            'orders' => $orders
        ]);
    }

    public function unapproved()
    {
        $orders = Order::where('approved_by',null)->get();

        return view('members.unapproved', [
            'orders' => $orders
        ]);
    }

    public function unassigned()
    {
        Carbon::setLocale('hu');

        $orders = [];
        $all_orders = Order::all()->sortByDesc('id')->all();
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
        Carbon::setLocale('hu');

        $orders = Order::all()->where('joint',true)->sortByDesc('id')->all();

        return view('members.joint', [
            'orders' => $orders
        ]);
    }

    public function active()
    {
        Carbon::setLocale('hu');

        $orders = Order::withCount('assignedUsers')->where('archived',false)->get()->sortByDesc('id');

        return view('members.active', [
            'orders' => $orders
        ]);
    }

    public function archived()
    {
        Carbon::setLocale('hu');

        $orders = Order::withCount('assignedUsers')->where('archived',true)->get()->sortByDesc('id');

        return view('members.archived', [
            'orders' => $orders
        ]);
    }
}
