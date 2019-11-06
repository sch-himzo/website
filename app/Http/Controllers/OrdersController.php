<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function create(Request $request)
    {
        return view('orders.new');
    }
}
