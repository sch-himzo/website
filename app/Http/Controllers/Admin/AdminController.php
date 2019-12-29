<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.index',[
            'users' => $users
        ]);
    }

    public function user(User $user)
    {
        Session::put('return_to','admin.user');
        Session::put('return_to_parameters', ['user' => $user]);

        return view('admin.user', [
            'user' => $user,
            'orders' => $user->orders
        ]);
    }

    public function userSetWebadmin(User $user)
    {
        $user->role_id = 6;
        $user->save();

        return redirect()->back();
    }

    public function userUnsetWebadmin(User $user)
    {
        $user->role_id = 1;
        $user->save();

        return redirect()->back();
    }
}
