<?php

namespace App\Http\Controllers;

use App\Models\Order\Group;
use App\Models\Order\Image;
use App\Models\Order\Order;
use App\Models\Setting;
use App\Models\TempUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Str;

class NewOrderController extends Controller
{
    protected $allowed_extensions = [
        'jpg','jpeg','png','gif','svg'
    ];

    protected $order_types = [
        'badge' => 1,
        'shirt' => 2,
        'jumper' => 3
    ];

    public function create(Request $request)
    {
        $min_time_setting = Setting::all()->where('name','min_order_time')->first();
        $min_date_setting = Setting::all()->where('name','min_order_date')->first();

        if($min_date_setting==null || $min_date_setting->setting==null || $min_date_setting->setting<time()) {
            if($min_time_setting == null) {
                $min_time = date("Y-m-d",7*24*60+time());
            }else{
                $min_time = date("Y-m-d", $min_time_setting->setting + time());
            }
        }else{
            $min_time = date("Y-m-d", $min_date_setting->setting);
        }

        return view('orders.new', [
            'min_date' => $min_time
        ]);
    }

    public function fake()
    {
        return view('orders.fake');
    }

    public function save(Request $request, Group $group)
    {
        set_time_limit(300);
        $order = new Order();
        $order->title = $request->input('title');
        $order->count = $request->input('count');
        $order->order_group_id = $group->id;
        $order->size = $request->input('size');
        $order->existing_design = $request->input('existing')!=null;
        $order->comment = $request->input('comment');
        $order->type = $this->order_types[$request->input('type')];
        $order->save();

        $font = $request->file('font');


        if($font!=null && strtolower($font->getClientOriginalExtension())!="ttf"){
            $font = null;
        }


        if($font!=null){
            $new_name = $font->getClientOriginalName() . "." . time() . ".ttf";

            File::put(storage_path('app/fonts/') . $new_name, $font);
            $order->font = $new_name;
            $order->save();
        }
        if($request->input('existing')==null){
            $images = $request->file('image');
            foreach($images as $file){

                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize()/1024/1024;

                if($size>3){
                    continue;
                }

                if(!in_array($ext,$this->allowed_extensions)){
                    continue;
                }

                $image = new Image();
                $image->image = static::thumbnail($file);
                $image->order_id = $order->id;
                $image->save();
            }
        }

        return redirect()->route('orders.new.finished', ['group' => $group]);

    }

    public function step2(Request $request, Group $group = null)
    {
        set_time_limit(300);
        if($request->input('form_type')=='first'){
            $title = $request->input('title');
            $time_limit = $request->input('time_limit');
            $comment = $request->input('comment');
            $public_albums = $request->input('public_albums');

            $min_time_setting = Setting::all()->where('name','min_order_time')->first();
            $min_date_setting = Setting::all()->where('name','min_order_date')->first();

            if($min_date_setting==null || $min_date_setting->setting==null || $min_date_setting->setting<time()) {
                if($min_time_setting == null) {
                    $min_time = 7*24*60+time();
                }else{
                    $min_time = $min_time_setting->setting + time();
                }
            }else{
                $min_time = $min_date_setting->setting;
            }

            if(strtotime($time_limit)<$min_time) {
                abort(400);
            }

            if($request->input('email')){
                $existing_user = User::where('email',$request->input('email'))->first();
                if($existing_user==null){
                    $user = new TempUser();
                    $user->name = $request->input('name');
                    $user->email = $request->input('email');
                    $user->save();
                }
            }else{
                $existing_user = null;
                $user = null;
            }

            $group = new Group();
            $group->title = $title;
            $group->time_limit = $time_limit;
            $group->comment = $comment;
            $group->public_albums = $public_albums!=null;
            if($existing_user!=null){
                $group->user_id = $existing_user->id;
            }elseif($user!=null){
                $group->temp_user_id = $user->id;
            }else{
                $group->user_id = Auth::id();
            }
            $group->save();
        }else{
            $order = new Order();
            $order->title = $request->input('title');
            $order->count = $request->input('count');
            $order->order_group_id = $group->id;
            $order->size = $request->input('size');
            $order->existing_design = $request->input('existing')!=null;
            $order->comment = $request->input('comment');
            $order->type = $this->order_types[$request->input('type')];
            $order->save();

            if($request->input('existing')==null){
                $images = $request->file('image');
                foreach($images as $file){

                    $ext = $file->getClientOriginalExtension();
                    $size = $file->getSize()/1024/1024;

                    if($size>3){
                        continue;
                    }

                    if(!in_array($ext,$this->allowed_extensions)){
                        continue;
                    }

                    $image = new Image();
                    $image->image = static::thumbnail($file);
                    $image->order_id = $order->id;
                    $image->save();
                }
            }

        }

        return redirect()->route('orders.new.new_step_2', ['group' => $group]);
    }

    public function newStep2(Group $group)
    {
        return view('orders.new_step_2', [
            'group' => $group
        ]);
    }

    public function deleteStep2(Order $order)
    {
        foreach($order->images as $image)
        {
            File::delete([public_path('/storage/images/thumbnails/'). $image->image, public_path('/storage/images/real/'). $image->image]);
        }

        $order->delete();

        return redirect()->back();
    }

    public function delete(Group $group)
    {
        $group->delete();

        return redirect()->route('index');
    }

    public function finished(Group $group)
    {

        Carbon::setLocale('hu');

        $order_types = [
            '1' => 'Folt',
            '3' => 'Pulcsira hímzendő',
            '2' => 'Pólóra hímzendő'
        ];

        return view('orders.final', ['group' => $group, 'order_types' => $order_types]);
    }


    public static function thumbnail(UploadedFile $file)
    {
        $image_name = time() . '.' . Str::random(5) . '.jpg';

        $destination_path = public_path('storage/images/thumbnails');
        $img = \Intervention\Image\Facades\Image::make($file->path());
        $img->resize(150,150, function($constraint){
            $constraint->aspectRatio();
        })->encode('jpg',90)->save($destination_path.'/'.$image_name);

        $destination_path = public_path('storage/images/real');
        $img = \Intervention\Image\Facades\Image::make($file->path());
        $img->resize(500,500, function($constraint){
            $constraint->aspectRatio();
        })->encode('jpg',90)->save($destination_path.'/'.$image_name);

        return $image_name;
    }
}
