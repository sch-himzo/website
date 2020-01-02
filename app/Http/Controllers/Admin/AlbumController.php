<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery\Album;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function album(Album $album)
    {
        return view('admin.albums.album', [
            'album' => $album
        ]);
    }

    public function new(Request $request)
    {
        $name = $request->input('name');
        $role_id = $request->input('role');
        $gallery_id = $request->input('gallery');

        if(!is_integer((int)$role_id)){
            return redirect()->back();
        }

        if($role_id>Auth::user()->role_id){
            abort(401);
        }

        $album = new Album();
        $album->name = $name;
        $album->gallery_id = $gallery_id;
        $album->role_id = $role_id;
        $album->save();

        return redirect()->back();
    }
}
