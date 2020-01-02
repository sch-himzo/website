<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignGroup;
use Auth;
use File;
use Illuminate\Http\Request;
use Storage;

class DesignsController extends Controller
{
    public function index()
    {
        $design_groups = DesignGroup::where('parent_id',null)->get();

        return view('admin.designs.index', [
            'design_groups' => $design_groups
        ]);
    }

    public function group(DesignGroup $design_group)
    {
        $route = [];

        for($i = $design_group; $i != null; $i = $i->parent){
            $route[] = $i;
        }

        $send = [];

        for($i = sizeof($route)-1; $i >=0; $i--){
            $send[] = $route[$i];
        }

        return view('admin.designs.group', [
            'group' => $design_group,
            'route' => $send
        ]);
    }

    public function newGroup(Request $request)
    {
        $name = $request->input('name');
        $parent = $request->input('parent');

        $group = new DesignGroup();
        $group->name = $name;
        if($parent!=null){
            $group->parent_id = $parent;
        }
        $group->owner_id = Auth::user()->id;
        $group->save();

        return redirect()->back();
    }

    public function deleteGroup(DesignGroup $design_group)
    {
        $design_group->delete();

        return redirect()->back();
    }

    public function editGroup(Request $request, DesignGroup $design_group)
    {
        $name = $request->input('name_'. $design_group->id);

        $design_group->name = $name;
        $design_group->save();

        return redirect()->back();
    }

    public function upload(Request $request, DesignGroup $design_group)
    {
        if($request->file('image')!=null){
            $file = $request->file('image');
            $size = $file->getSize()/1024/1024;

            if($size>5){
                abort(400);
            }

            $extension = strtolower($file->getClientOriginalExtension());

            if(!in_array($extension, ['dst','art60','art80','jpg','jpeg','png','gif','tiff','bmp'])){
                abort(400);
            }

            $new_name = $file->getClientOriginalName() . '.' . $extension;

            Storage::disk()->put('images/uploads/designs/'.$new_name,File::get($file));

            $design = new Design();

            $design->design_group_id = $design_group->id;
            $design->name = $request->input('title');
            $design->image = $new_name;
            $design->save();

            return redirect()->back();
        }else{
            return abort(400);
        }
    }

    public function deleteDesign(Design $design)
    {
        $design->delete();

        return redirect()->back();
    }
}
