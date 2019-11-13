<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function getUsers(Request $request)
    {
        $users_in_club = User::all()
            ->where('in_club','1')
            ->where('role_id','>','1')
            ->all();

        $users = [];
        $ids = [];

        if($users_in_club!=null){
            foreach($users_in_club as $user){
                $users[] = $user->name;
                $ids[] = $user->id;
            }
        }

        return response()->json([
            'users' => $users,
            'ids' => $ids
        ]);
    }
}
