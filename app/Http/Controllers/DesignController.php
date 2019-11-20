<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Design;
use App\Models\DesignGroup;
use App\Models\Order;
use App\Models\Setting;
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

    public function order(Order $order)
    {
        $group = $order->design;

        return view('designs.order',[
            'order' => $order,
            'group' => $group
        ]);
    }

    public function updateOrder(Request $request, Order $order, Design $design)
    {
        if($request->file('file_'.$design->id)){
            $file = $request->file('file_'.$design->id);

            $ext = strtolower($file->getClientOriginalExtension());
            $name = $file->getClientOriginalName();
            $new_name = time().$name;
            $size = $file->getSize()/1024/1024;
            if($size>5){
                abort(400);
            }
            if(!in_array($ext,['art60','art80','dst'])){
                abort(400);
            }
            Storage::disk()->put('images/uploads/designs/'.$new_name,File::get($file));

            $design->name = $name;
            $design->image = $new_name;
            $design->save();

            return redirect()->back();
        }
    }

    public function addToOrder(Request $request, Order $order)
    {
        if($request->file('art80_'. $order->id) && $request->file('dst_'.$order->id)){
            $art = $request->file('art80_'. $order->id);
            $dst = $request->file('dst_'. $order->id);

            $art_extension = strtolower($art->getClientOriginalExtension());
            $dst_extension = strtolower($dst->getClientOriginalExtension());

            $art_size = $art->getSize()/1024/1024;
            $dst_size = $dst->getSize()/1024/1024;

            if($art_size > 5 || $dst_size > 5){
                abort(400);
            }

            if(!in_array($art_extension,['art80','art60']) || $dst_extension!='dst'){
                abort(400);
            }

            $art_o_name = $art->getClientOriginalName();
            $dst_o_name = $dst->getClientOriginalName();
            $art_name = time().$art->getClientOriginalName();
            $dst_name = time().$dst->getClientOriginalName();

            Storage::disk()->put('images/uploads/designs/'.$art_name,File::get($art));
            Storage::disk()->put('images/uploads/designs/'.$dst_name,File::get($dst));

            $orders_group = Setting::all()->where('name','orders_group')->first()->setting;

            $orders_group = DesignGroup::all()->find($orders_group);

            $old_group = DesignGroup::all()
                ->where('name',$order->title)
                ->where('parent_id',$orders_group->id)
                ->first();

            if($old_group==null){
                $group = new DesignGroup();
                $group->name = $order->title;
                $group->parent_id = $orders_group->id;
                $group->owner_id = Auth::user()->id;
                $group->save();
            }else{
                $group = $old_group;
            }

            $art_design = new Design();
            $art_design->name = $art_o_name;
            $art_design->image = $art_name;
            $art_design->design_group_id = $group->id;
            $art_design->save();

            $dst_design = new Design();
            $dst_design->name = $dst_o_name;
            $dst_design->image = $dst_name;
            $dst_design->design_group_id = $group->id;
            $dst_design->save();

            $order->design_id = $group->id;
            $order->status = 'designed';
            $order->save();

            return redirect()->route('designs.orders.view', ['order' => $order]);
        }else{
            return abort(400);
        }
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
        if(Auth::user()->role_id<2){
            abort(401);
        }

        $path = $design->image;
        return response()->download(storage_path("app/images/uploads/designs/" . $path));
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

    public function colors(Request $request, Design $design)
    {
        if($design->colors->count()!=0){
            $count = $request->input('colors');
            for($i = 0; $i<$count; $i++){
                $r = $request->input('r_'.$i);
                $g = $request->input('g_'.$i);
                $b = $request->input('b_'.$i);
                $stitches = $request->input('color_stitches_'.$i);
                $code = $request->input('color_'.$i);
                $isacord = $request->input('color_isa_'.$i)=="isa";

                if($r == null){
                    $r = 0;
                }

                if($g == null){
                    $g = 0;
                }

                if($b == null){
                    $b = 0;
                }

                $color = $design->colors->where('number',$i)->first();
                $color->red = $r;
                $color->green = $g;
                $color->blue = $b;
                $color->isacord = $isacord;
                $color->code = $code;
                $color->design_id = $design->id;
                $color->stitch_count = $stitches;
                $color->number = $i;
                $color->save();
            }
        }else{
            $count = $request->input('colors');
            for($i = 0; $i<$count; $i++){
                $r = $request->input('r_'.$i);
                $g = $request->input('g_'.$i);
                $b = $request->input('b_'.$i);
                $stitches = $request->input('color_stitches_'.$i);
                $code = $request->input('color_'.$i);
                $isacord = $request->input('color_isa_'.$i)=="isa";

                if($r == null){
                    $r = 0;
                }

                if($g == null){
                    $g = 0;
                }

                if($b == null){
                    $b = 0;
                }

                $color = new Color();
                $color->red = $r;
                $color->green = $g;
                $color->blue = $b;
                $color->isacord = $isacord;
                $color->code = $code;
                $color->design_id = $design->id;
                $color->number = $i;
                $color->stitch_count = $stitches;
                $color->save();
            }
        }



        return redirect()->back();
    }
}
