<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function new(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $role_id = $request->input('role');

        if(!is_integer((int)$role_id)){
            return redirect()->back();
        }

        if($role_id>Auth::user()->role_id){
            abort(401);
        }

        $gallery = new Gallery();
        $gallery->name = $name;
        $gallery->description = $description;
        $gallery->role_id = $role_id;
        $gallery->save();

        return redirect()->back();
    }
}
