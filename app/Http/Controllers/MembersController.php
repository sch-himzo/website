<?php

namespace App\Http\Controllers;

use App\Models\Order\Group;
use App\Models\Order\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MembersController extends Controller
{
    public function index()
    {
        foreach(Group::all() as $group){
            if($group->orders()->count()==0){
                $group->delete();
            }
        }

        Carbon::setLocale('hu');

        Session::put('return_to','members.index');
        Session::put('return_to_parameters',null);

        $oneweek = date('Y-m-d',time()+7*24*60*60);

        $oneweekminus = date('Y-m-d H:i:s', time()-7*24*60*60);

        $time_limit = Group::where('time_limit','<',$oneweek)
            ->where('archived',0)
            ->where('status','!=','5')
            ->withCount('assignedUsers')
            ->get()
            ->sortByDesc('id')
            ->all();

        $recent = Group::where('updated_at', '>', $oneweekminus)
            ->where('status','5')
            ->withCount('assignedUsers')
            ->get()
            ->sortByDesc('id')
            ->all();

        $ready = Group::where('status','4')
            ->where('archived',false)
            ->orWhere('status','3')
            ->where('archived',false)
            ->get()
            ->sortByDesc('id');

        $help = Group::where('help','1')
            ->where('archived',false)
            ->withCount('assignedUsers')
            ->get()
            ->sortByDesc('id');

        return view('members.index',[
            'time_limit' => $time_limit,
            'recent' => $recent,
            'ready' => $ready,
            'help' => $help
        ]);
    }

    public function mine()
    {

        Session::put('return_to','members.mine');
        Session::put('return_to_parameters',null);

        Carbon::setLocale('hu');
        $orders = Auth::user()
            ->assignedOrders
            ->where('archived',0)
            ->where('joint_project',0)
            ->sortByDesc('time_limit');

        $archived = Auth::user()
            ->assignedOrders
            ->where('archived',1)
            ->sortByDesc('id');

        return view('members.mine', [
            'orders' => $orders,
            'archived' => $archived
        ]);
    }

    public function unapproved()
    {
        Session::put('return_to','members.unapproved');
        Session::put('return_to_parameters',null);

        $orders = Group::where('approved_by',null)->where('archived',0)->get();

        return view('members.unapproved', [
            'orders' => $orders
        ]);
    }

    public function unassigned()
    {
        Session::put('return_to','members.unassigned');
        Session::put('return_to_parameters',null);

        Carbon::setLocale('hu');

        $orders = [];
        $all_orders = Group::all()->where('archived',0)->where('approved_by','!=',null)->sortByDesc('time_limit')->all();
        foreach($all_orders as $order){
            if($order->assignedUsers->count()==0 && $order->joint_project==false){
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
        Session::put('return_to_parameters',null);

        Carbon::setLocale('hu');

        $orders = Group::all()
            ->where('joint_project',true)
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
        Session::put('return_to_parameters',null);

        Carbon::setLocale('hu');

        $orders = Group::withCount('assignedUsers')->where('archived',false)->get()->sortByDesc('id');

        return view('members.active', [
            'orders' => $orders
        ]);
    }

    public function archived()
    {
        Session::put('return_to','members.archived');
        Session::put('return_to_parameters',null);

        Carbon::setLocale('hu');

        $orders = Group::withCount('assignedUsers')->where('archived',true)->get()->sortByDesc('id');

        return view('members.archived', [
            'orders' => $orders
        ]);
    }
}
