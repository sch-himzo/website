<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function find(Request $request)
    {
        $search = $request->input('name');

        if($search == ""){
            return response()->json([]);
        }

        $users = User::where('name', 'like','%' . $search . '%')->get();

        $users_array = [];

        foreach($users as $user){
            $users_array[] = [
                'name' => $user->name,
                'id' => $user->id,
                'email' => $user->email
            ];
        }

        return response()->json($users);
    }

    public function disableEmail($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->allow_emails = false;
        $user->save();

        return view('user.disable_emails');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function disableEmails()
    {
        Auth::user()->allow_emails = false;
        Auth::user()->save();

        return redirect()->back();
    }

    public function enableEmails()
    {
        Auth::user()->allow_emails = true;
        Auth::user()->save();

        return redirect()->back();
    }
}
