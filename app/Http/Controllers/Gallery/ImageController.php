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

        if (file_exists($path = storage_path(sprintf('app/%s', $path)))) {
            return response()->file($path);
        }

        abort(404);
        die();
    }
}
