<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Gallery\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function get(Image $image)
    {
        $path = $image->image;
        return response()->file(storage_path("app/" . $path));
    }
}
