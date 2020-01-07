<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignGroup;
use App\Models\Gallery\Gallery;
use App\Models\Machine;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function misc()
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
        $current_machine = Machine::find(Setting::where('name','current_machine')->first()->setting);

        return view('admin.misc',[
            'galleries' => $galleries,
            'current_gallery' => $current_gallery,
            'current_orders_gallery' => $current_orders_gallery,
            'all_galleries' => $all_galleries,
            'all_folders' => $all_folders,
            'current_orders_folder' => $current_orders_folder,
            'current_machine' => $current_machine
        ]);
    }

    public function setPublicGallery(Request $request)
    {
        $gallery = $request->input('gallery');

        $setting = Setting::all()->where('name','home_gallery')->first();
        $setting->setting=$gallery;
        $setting->save();

        return redirect()->back();
    }

    public function setOrdersFolder(Request $request)
    {
        $new_folder = $request->input('folder_orders');

        $setting = Setting::all()->where('name','orders_group')->first();

        $setting->setting = $new_folder;
        $setting->save();

        return redirect()->back();
    }

    public function setOrdersGallery(Request $request)
    {
        $gallery = $request->input('gallery_orders');

        $setting = Setting::all()->where('name','orders_gallery')->first();

        $setting->setting = $gallery;
        $setting->save();

        return redirect()->back();
    }

    public function setMachineRole(Request $request)
    {
        $machine = Machine::find(Setting::where('name','current_machine')->first()->setting);

        $machine->viewable_by = $request->input('machine_role');
        $machine->save();

        return redirect()->back();
    }

}
