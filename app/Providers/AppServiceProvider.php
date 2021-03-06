<?php

namespace App\Providers;

use App\Models\Machine;
use App\Models\Order\Group;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $send_orders_count = 0;
        $joint_orders_count = 0;
        $orders = Group::withCount('assignedUsers')->get();
        foreach($orders as $order){
            if($order->assigned_users_count==0 && $order->approved_by!=null && $order->joint==false && !$order->archived){
                $send_orders_count++;
            }
            if($order->joint_project && !$order->archived){
                $joint_orders_count++;
            }
        }

        $machine = Machine::first();
//
        View::share('current_machine',$machine);

        View::share('send_orders_count', $send_orders_count);
        View::share('joint_orders_count', $joint_orders_count);
    }
}
