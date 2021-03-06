<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Gallery\Gallery;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function images()
    {
        $gallery = Setting::all()->where('name','home_gallery')->first()->setting;

        $gallery = Gallery::all()->where('id',$gallery)->first();

        if(!Auth::check()){
            $role = 1;
        }else{
            $role = Auth::user()->role_id;
        }

        $albums = $gallery->albums->where('role_id','<=',$role);


        return view('gallery.index',[
            'albums' => $albums
        ]);
    }

    public function gallery(Gallery $gallery)
    {

    }
}
