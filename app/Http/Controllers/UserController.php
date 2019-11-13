<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function orders()
    {
        $orders = Auth::user()->orders;

        return view('user.orders',[
            'orders' => $orders
        ]);
    }

    public function in()
    {
        if(Auth::user()->role_id<2){
            abort(401);
        }

        Auth::user()->in_club = true;
        Auth::user()->save();

        return redirect()->back();
    }

    public function out()
    {
        if(Auth::user()->role_id<2){
            abort(401);
        }

        Auth::user()->in_club = false;
        Auth::user()->save();

        return redirect()->back();
    }
}
