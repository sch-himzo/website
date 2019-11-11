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
}
