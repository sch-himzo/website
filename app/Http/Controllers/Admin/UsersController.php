<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Group;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);

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
            'orders' => Group::where('user_id',$user->id)->paginate(15)
        ]);
    }

    public function edit(User $user, Request $request) {
        $role = $request->input('role');
        $sticky = $request->input('sticky');


        $user->role_id = $role;
        $user->sticky_role = $sticky ? true : false;
        $user->save();

        return redirect()->back();
    }
}
