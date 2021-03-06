<?php

namespace App\Http\Controllers;

use App\Generator\GeneratorInterface;
use App\Generator\SVGGenerator;
use App\Models\Background;
use App\Models\Color;
use App\Models\Design;
use App\Models\DesignGroup;
use App\Models\Order\Order;
use App\Models\Setting;
use App\Parser\DSTParser;
use App\Parser\ParserInterface;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;

class DesignController extends Controller
{
    /** @var ParserInterface $dstParser */
    private $dstParser;

    /** @var GeneratorInterface */
    private $svgGenerator;

    public function __construct(
        DSTParser $dstParser,
        SVGGenerator $svgGenerator
    ) {
        $this->dstParser = $dstParser;
        $this->svgGenerator = $svgGenerator;
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

            $colors = $design->colors;

            if($colors->count()!=0){
                foreach($colors as $color){
                    $color->delete();
                }
            }

            $design->name = $name;
            $design->image = $new_name;
            $design->stitch_count = null;
            $design->svg = null;

            $design->save();

            return redirect()->route('designs.parse', ['design' => $design, 'order' => $order]);
        }else{
            abort(400);
        }
    }

    public function addToOrder(Request $request, Order $order)
    {

        $dst = $request->file('dst_'. $order->id);

        if(!$dst) {
            return redirect()->back();
        }

        $dst_extension = strtolower($dst->getClientOriginalExtension());

        $dst_size = $dst->getSize()/1024/1024;
        if($dst_size > 5){
            abort(400);
        }



        if($dst_extension!='dst'){
            abort(400);
        }
        $dst_o_name = $dst->getClientOriginalName();
        $dst_name = time().$dst->getClientOriginalName();

        Storage::disk()->put('images/uploads/designs/'.$dst_name,File::get($dst));

        $orders_group = Setting::all()->where('name','orders_group')->first()->setting;

        $orders_group = DesignGroup::all()->find($orders_group);

        $old_group = DesignGroup::all()
            ->where('name',$order->title)
            ->where('parent_id',$orders_group->id)
            ->first();

        if($old_group==null){
            $group = new DesignGroup();
            $group->name = $order->group->title . " - " . $order->title;
            $group->parent_id = $orders_group->id;
            $group->owner_id = Auth::user()->id;
            $group->save();
        }else{
            $group = $old_group;
        }

        $dst_design = new Design();
        $dst_design->name = $dst_o_name;
        $dst_design->image = $dst_name;
        $dst_design->design_group_id = $group->id;
        $dst_design->save();

        $order->design_group_id = $group->id;
        $order->status = 1;
        $order->save();

        $art = $request->file('art80_'. $order->id);
        if($art) {
            $art_extension = strtolower($art->getClientOriginalExtension());
            $art_size = $art->getSize()/1024/1024;
            if(!in_array($art_extension,['art60','art80'])) {
                abort(400);
            }
            if($art_size>5) {
                abort(400);
            }

            $art_o_name = $art->getClientOriginalName();
            $art_name = time().$art->getClientOriginalName();
            Storage::disk()->put('images/uploads/designs/'.$art_name,File::get($art));

            $art_design = new Design();
            $art_design->name = $art_o_name;
            $art_design->image = $art_name;
            $art_design->design_group_id = $group->id;
            $art_design->save();
        }
        return redirect()->route('orders.view', ['group' => $order->group, 'order' => $order]);
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

            $extension = strtolower($file->getClientOriginalExtension());

            if(!in_array($extension, ['dst','art60','art80','jpg','jpeg','png','gif','tiff','bmp'])){
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

    public function colors(Request $request, Design $design)
    {
        $diameter = $request->input('diameter');
        $background = $request->input('background');
        $width = $request->input('width');
        $height = $request->input('height');
        $minx = $request->input('xoffset');
        $miny = $request->input('yoffset');
        if($design->colors->count()!=0){
            $count = $request->input('colors');

            $colors = [];

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
                $color->isacord = $isacord;
                $color->code = $code;
                $color->design_id = $design->id;
                $color->stitch_count = $stitches;
                $color->number = $i;
                $color->save();

                $colors[] = $color;
            }
            $bg = Background::all()->find($background);

            $dst = $this->dstParser->parse($design);

            $svg = $this->svgGenerator->generate($design, $dst);

            $design->svg = $svg;

            $design->size = $diameter*2;
            $design->background_id = $background;
            $design->save();
        }else{
            $count = $request->input('colors');

            $colors = [];

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
                $color->isacord = $isacord;
                $color->code = $code;
                $color->design_id = $design->id;
                $color->number = $i;
                $color->stitch_count = $stitches;
                $color->save();

                $colors[] = $color;
            }

            $bg = Background::all()->find($background);

            $dst = $this->dstParser->parse($design);

            $design->svg = $this->svgGenerator->generate($design, $dst);
            $design->size = $diameter*2;
            $design->background_id = $background;
            $design->save();
        }

        return redirect()->back();
    }

    public function attachGroupToOrder(DesignGroup $design, Order $order)
    {
        $order->design_group_id = $design->id;
        $order->original = false;
        $order->status=1;
        $order->save();

        return redirect()->back();
    }

    public function find(Request $request)
    {
        $search = $request->input('search');
        if($search==""){
            return response()->json(['empty' => true]);
        }

        $setting = Setting::all()->where('name','orders_group')->first()->setting;

        $groups = DesignGroup::where('name','like','%'.$search.'%')
            ->where('parent_id',$setting)
            ->limit(10)
            ->get();

        $to_send = [];

        foreach($groups as $group){
            $to_send[] = [
                'id' => $group->id,
                'name' => $group->name
            ];
        }

        return response()->json($to_send);
    }

    public function updateSingle(Request $request, Order $order)
    {
        if($request->file('art80_'.$order->id)){

            $art = $request->file('art80_'. $order->id);
            $art_extension = strtolower($art->getClientOriginalExtension());
            $art_size = $art->getSize()/1024/1024;
            if($art_size>5){
                abort(400);
            }
            if(!in_array($art_extension,['art80','art60'])){
                abort(400);
            }
            $art_o_name = $art->getClientOriginalName();
            $art_name = time().$art->getClientOriginalName();
            Storage::disk()->put('images/uploads/designs/'.$art_name,File::get($art));

            $designs = $order->design->designs;
            foreach($designs as $design){
                if($design->extension()!="dst"){
                    $art = $design;
                }
            }

            $art->image = $art_name;
            $art->name = $art_o_name;
            $art->save();
        }

        if($request->file('dst_'.$order->id)){
            $dst = $request->file('dst_'. $order->id);

            $dst_extension = strtolower($dst->getClientOriginalExtension());
            $dst_size = $dst->getSize()/1024/1024;

            if($dst_extension!="dst" || $dst_size>5){
                abort(400);
            }

            $dst_o_name = $dst->getClientOriginalName();
            $dst_name = time().$dst->getClientOriginalName();
            Storage::disk()->put('images/uploads/designs/'.$dst_name,File::get($dst));

            $designs = $order->design->designs;
            foreach($designs as $design){
                if($design->extension()=="dst"){
                    $dst = $design;
                }
            }

            $dst->name = $dst_o_name;
            $dst->image = $dst_name;
            $dst->save();
        }

        return redirect()->route('designs.redraw', ['order' => $order]);
    }
}
