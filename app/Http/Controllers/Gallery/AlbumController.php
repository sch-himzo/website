<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Gallery\Album;
use App\Models\Gallery\Gallery;
use App\Models\Gallery\Image;
use App\Models\Order;
use App\Models\Setting;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    private $allowed_extensions = ['png','jpg','jpeg','gif'];

    public function create(Order $order=null)
    {
        $gallery = Setting::all()->where('name','orders_gallery')->first()->setting;
        $gallery = Gallery::find($gallery);

        if(Auth::user()->role_id<$gallery->role_id){
            abort(401);
        }

        return view('gallery.album.create',[
            'order' => $order
        ]);
    }

    public function editUploadedImages(Request $request, Order $order)
    {
        $gallery = Setting::all()->where('name','orders_gallery')->first()->setting;
        $gallery = Gallery::find($gallery);

        if(Auth::user()->role_id<$gallery->role_id){
            abort(401);
        }

        $files = $request->file('images');
        if(sizeof($files)==0){
            return redirect()->back();
        }

        $album = new Album();
        $album->gallery_id = $gallery->id;
        $album->name = $request->input('name');
        $album->role_id = $gallery->role_id;
        $album->save();

        $images = [];

        foreach($files as $image){
            $extension = strtolower($image->extension());
            $time = time();
            $size = $image->getSize()/1024/1024;
            if($size>5){
                abort(400);
            }
            if(!in_array($extension, $this->allowed_extensions)){
                abort(400);
            }

            $new_name = 'images/uploads/' . $time . $image->getFilename() . '.' . $extension;
            Storage::disk()->put($new_name,File::get($image));

            $image = new Image();
            $image->image = $new_name;
            $image->album_id = $album->id;
            $image->title = "";
            $image->description = "";
            $image->user_id = Auth::user()->id;
            $image->save();

            $images[] = $image;
        }

        $image_ids = "";
        foreach($images as $image){
            $image_ids .= $image->id.".";
        }

        return view('gallery.album.orders.edit_uploaded', [
            'album' => $album,
            'order'=> $order,
            'images' => $images,
            'image_ids' => $image_ids
        ]);
    }

    public function save(Order $order, Album $album, Request $request)
    {
        if(Auth::user()->role_id<$album->role_id){
            abort(401);
        }

        $images = $request->input('images');
        $images = explode('.',$images);
        foreach($images as $image){
            if($image==""){
                continue;
            }
            $title = $request->input('title_'.$image);
            $description = $request->input('description_'.$image);

            $current_image = Image::find($image);
            $current_image->title = $title;
            $current_image->description = $description;
            $current_image->save();
        }

        $album->orders()->attach($order);
        $album->save();

        return redirect()->route('albums.view', ['album' => $album]);
    }

    public function view(Album $album)
    {
        if($album->role_id!=1){
            if(!Auth::check()){
                return redirect()->route('index.login');
            }
            if(Auth::user()->role_id<$album->role_id){
                abort(401);
            }
        }

        return view('gallery.album.view', ['album' => $album]);
    }
}
