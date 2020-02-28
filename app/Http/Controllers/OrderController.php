<?php

namespace App\Http\Controllers;

use App\Models\Gallery\Album;
use App\Models\Order\Group;
use App\Models\Order\Image;
use App\Models\Order\Order;
use App\Models\Setting;
use Auth;
use Illuminate\Http\Request;
use Str;

class OrderController extends Controller
{
    protected $allowed_extensions = [
        'jpg','jpeg','png','gif','svg'
    ];

    public function image(Image $image)
    {
        $path = $image->image;
        return response()->file(storage_path("app/" . $path));
    }

    public function font(Order $order)
    {
        $path = 'app/fonts/uploads/'.$order->font;
        return response()->download(storage_path($path));
    }

    public function albums(Order $order)
    {
        $albums = $order->albums;

        $role = Auth::check() ? Auth::user()->role_id : 1;

        return view('orders.albums', [
            'role' => $role,
            'albums' => $albums,
            'order' => $order
        ]);
    }

    public function view(Group $group, Order $order)
    {
        $dst = $order->getDST();
        $order_types = [
            1 => 'Folt',
            2 => 'Pólóra hímzendő',
            3 => 'Pulcsira hímzendő'
        ];

        $statuses = [
            0 => 'Beérkezett',
            1 => 'Tervezve',
            2 => 'Próbahímzés kész',
            3 => 'Hímezve',
            4 => 'Fizetve',
            5 => 'Átadva'
        ];

        if($dst==null){
            $allowed = array_slice($statuses,0,1);
        }elseif($dst!=null && $dst->colors->count()==0){
            $allowed = array_slice($statuses,0,2);
        }elseif($dst!=null && $dst->colors->count()!=0 && $order->testAlbum==null){
            $allowed = array_slice($statuses, 0, 2);
        }else{
            $allowed = $statuses;
        }
        if(Auth::user()->role_id>=5) {
            $allowed = $statuses;
        }

        return view('orders.order', [
            'group' => $group,
            'order' => $order,
            'dst' => $dst,
            'order_types' => $order_types,
            'statuses' => $statuses,
            'allowed_statuses' => $allowed
        ]);
    }

    public function status(Request $request, Order $order)
    {
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back();
    }

    public function existing(Order $order)
    {
        $order->existing_design = !$order->existing_design;
        $order->original = !$order->existing_design;
        $order->save();

        return redirect()->back();
    }

    public function testImage(Request $request, Order $order)
    {

        if($order->getDST()==null || $order->getDST()->colors->count()==0){
            abort(401);
        }

        if($request->file('image')){
            $image = $request->file('image');

            $extension = strtolower($image->getClientOriginalExtension());
            $size = $image->getSize()/1024/1024;

            if(!in_array($extension,$this->allowed_extensions)){
                abort(400);
            }
            if($size>3){
                return redirect()->back();
            }

            $name = time().Str::random(2).'.'.$image->getClientOriginalExtension();

            $destination_path = public_path('/storage/images/thumbnails');
            $thumbnail = \Intervention\Image\Facades\Image::make($image->path());
            $thumbnail->resize(200,200,function($constraint){
                $constraint->aspectRatio();
            })->save($destination_path.'/'. $name);
            $destination_path = public_path('/storage/images/real');
            $img = \Intervention\Image\Facades\Image::make($image->path());
            $img->resize(1000,1000,function($constraint){
                $constraint->aspectRatio();
            })->save($destination_path.'/'.$name);

            $gallery = Setting::where('name','orders_gallery')->first()->setting;

            $album = new Album();
            $album->gallery_id = $gallery;
            $album->name = $order->title . " - Próbahímzés";
            $album->role_id = 2;
            $album->save();

            $image = new \App\Models\Gallery\Image();
            $image->album_id = $album->id;
            $image->image = $name;
            $image->title = $order->title . " - Próbahímzés";
            $image->description = "Próbahímzés";
            $image->user_id = Auth::id();
            $image->save();

            $order->test_album_id = $album->id;
            $order->status=2;
            $order->save();

        }
        return redirect()->back();
    }
}
