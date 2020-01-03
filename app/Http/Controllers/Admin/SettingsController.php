<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Background;
use App\Models\DesignGroup;
use App\Models\Gallery\Gallery;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function gallery()
    {
        $galleries = Gallery::all();
        $roles = Role::all()->where('id','<=',Auth::user()->role_id)->all();

        return view('settings.gallery',[
            'galleries' => $galleries,
            'roles' => $roles
        ]);
    }

    public function setFolder(Request $request)
    {
        $new_folder = $request->input('folder_orders');

        $setting = Setting::all()->where('name','orders_group')->first();

        $setting->setting = $new_folder;
        $setting->save();

        return redirect()->back();
    }

    public function index()
    {
        $galleries = Gallery::all()->where('role_id','<','2');
        $all_galleries = Gallery::all();
        $current_gallery = Setting::all()->where('name','home_gallery')->first()->setting;
        $current_orders_gallery = Setting::all()->where('name','orders_gallery')->first();
        $current_orders_folder = Setting::all()->where('name','orders_group')->first()->setting;
        $all_folders = DesignGroup::all()->where('parent_id',null)->all();


        if($current_orders_gallery==null){
            $current_orders_gallery = 1;
        }else{
            $current_orders_gallery = Gallery::where('id',$current_orders_gallery->setting)->first()->id;
        }

        $current_gallery = Gallery::where('id',$current_gallery)->first();

        return view('settings.index',[
            'galleries' => $galleries,
            'current_gallery' => $current_gallery,
            'current_orders_gallery' => $current_orders_gallery,
            'all_galleries' => $all_galleries,
            'all_folders' => $all_folders,
            'current_orders_folder' => $current_orders_folder
        ]);
    }

    public function backgrounds()
    {
        $backgrounds = Background::all();

        return view('settings.backgrounds', [
            'backgrounds' => $backgrounds
        ]);
    }

    public function newBackground(Request $request)
    {
        $name = $request->input('name');
        $red = $request->input('red');
        $green = $request->input('green');
        $blue = $request->input('blue');

        if(!($name && $red && $green && $blue)){
            abort(400);
        }

        if(!(is_integer((int)$name) && is_integer((int)$green) && is_integer((int)$blue))){
            abort(400);
        }

        $background = new Background();
        $background->name = $name;
        $background->red = $red;
        $background->green = $green;
        $background->blue = $blue;
        $background->save();

        return redirect()->back();
    }

    public function editBackground(Request $request, Background $background)
    {
        $name = $request->input('name_'.$background->id);
        $red = $request->input('red_'.$background->id);
        $green = $request->input('green_'.$background->id);
        $blue = $request->input('blue_'.$background->id);

        $background->name = $name;
        $background->red = $red;
        $background->green = $green;
        $background->blue = $blue;
        $background->save();

        return redirect()->back();

    }

    public function deleteBackground(Request $request, Background $background)
    {
        $background->delete();

        return redirect()->back();
    }
}
