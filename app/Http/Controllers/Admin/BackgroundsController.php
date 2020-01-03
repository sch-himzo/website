<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Background;
use Illuminate\Http\Request;

class BackgroundsController extends Controller
{
    public function index()
    {
        $backgrounds = Background::all();

        return view('admin.backgrounds.index', [
            'backgrounds' => $backgrounds
        ]);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        $red = $request->input('red');
        $green = $request->input('green');
        $blue = $request->input('blue');

        if(!($name && $red && $green && $blue)){
            abort(400);
        }

        if(!(is_integer((int)$red) && is_integer((int)$green) && is_integer((int)$blue))){
            abort(400);
        }

        $background = new Background();
        $background->name = $name;
        $background->red = $red;
        $background->green = $green;
        $background->blue = $blue;
        $background->save();

        return redirect()->back();
    }

    public function edit(Request $request, Background $background)
    {
        $name = $request->input('name_'.$background->id);
        $red = $request->input('red_'.$background->id);
        $green = $request->input('green_'.$background->id);
        $blue = $request->input('blue_'.$background->id);

        $background->name = $name;
        $background->red = $red;
        $background->green = $green;
        $background->blue = $blue;
        $background->save();

        return redirect()->back();
    }

    public function delete(Request $request, Background $background)
    {
        $background->delete();

        return redirect()->back();
    }
}
