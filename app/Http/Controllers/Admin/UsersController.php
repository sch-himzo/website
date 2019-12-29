<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function user(User $user)
    {
        Session::put('return_to','admin.users.user');
        Session::put('return_to_parameters', ['user' => $user]);

        return view('admin.users.user', [
            'user' => $user,
            'orders' => $user->orders
        ]);
    }

    public function toggleAdmin(User $user)
    {
        if($user->id == Auth::id()){
            abort(400);
        }

        if($user->role_id==6){
            $user->role_id = 1;
        }else{
            $user->role_id = 6;
        }

        $user->save();

        return redirect()->back();
    }
}
