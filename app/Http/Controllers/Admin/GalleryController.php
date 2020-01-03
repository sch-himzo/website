<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery\Gallery;
use App\Models\Role;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        $roles = Role::all()->where('id','<=',Auth::user()->role_id)->all();

        return view('admin.galleries.index', [
            'galleries' => $galleries,
            'roles' => $roles
        ]);
    }

    public function gallery(Gallery $gallery)
    {
        Session::put('return_to','admin.galleries.index');
        $roles = Role::all()->where('id','<=',Auth::user()->role_id)->all();

        return view('admin.galleries.gallery', [
            'gallery' => $gallery,
            'albums' => $gallery->albums,
            'roles' => $roles
        ]);
    }

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

    public function delete(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->back();
    }
}
