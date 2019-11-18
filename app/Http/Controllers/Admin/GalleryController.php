<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery\Gallery;
use App\Models\Setting;
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

    public function set(Request $request)
    {
        $gallery = $request->input('gallery');

        $setting = Setting::all()->where('name','home_gallery')->first();
        $setting->setting=$gallery;
        $setting->save();

        return redirect()->back();
    }

    public function setOrderGallery(Request $request)
    {
        $gallery = $request->input('gallery_orders');

        $setting = Setting::all()->where('name','orders_gallery')->first();

        $setting->setting = $gallery;
        $setting->save();

        return redirect()->back();
    }
}
