<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\DesignGroup;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;

class DesignController extends Controller
{
    public function index()
    {
        $design_groups = DesignGroup::all()
            ->where('parent_id',null);

        return view('designs.index',[
            'design_groups' => $design_groups
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

    public function viewGroup(DesignGroup $group)
    {
        $route = [];

        for($i = $group; $i != null; $i = $i->parent){
            $route[] = $i;
        }

        $send = [];

        for($i = sizeof($route)-1; $i >=0; $i--){
            $send[] = $route[$i];
        }

        return view('designs.group.view',[
            'group' => $group,
            'route' => $send
        ]);
    }

    public function get(Design $design)
    {
        $path = $design->image;
        return response()->file(storage_path("app/images/uploads/designs/" . $path));
    }

    public function save(Request $request, DesignGroup $group)
    {
        if($request->file('image')!=null){
            $file = $request->file('image');
            $size = $file->getSize()/1024/1024;

            if($size>5){
                abort(400);
            }

            $extension = strtolower($file->extension());

            if(!in_array($extension, ['dst','art60','art80'])){
                abort(400);
            }

            $new_name = $file->getClientOriginalName() . '.' . $extension;

            Storage::disk()->put('images/uploads/designs/'.$new_name,File::get($file));

            $design = new Design();

            $design->design_group_id = $group->id;
            $design->name = $request->input('title');
            $design->image = $new_name;
            $design->save();

            return redirect()->back();
        }else{
            return abort(400);
        }
    }

    public function editGroup(Request $request, DesignGroup $group)
    {
        if(!$group->hasPermission(Auth::user())){
            abort(401);
        }

        $name = $request->input('name_'.$group->id);

        if($name!=""){
            $group->name = $name;
            $group->save();
        }else{
            abort(400);
        }

        return redirect()->back();
    }

    public function deleteGroup(DesignGroup $group)
    {
        if(!$group->hasPermission(Auth::user())){
            abort(401);
        }

        $group->delete();

        return redirect()->back();
    }
}
