<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Background;
use App\Models\DesignGroup;
use App\Models\Gallery\Gallery;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function gallery()
    {
        $galleries = Gallery::all();
        $roles = Role::all()->where('id','<=',Auth::user()->role_id)->all();

        return view('settings.gallery',[
            'galleries' => $galleries,
            'roles' => $roles
        ]);
    }

    public function backgrounds()
    {
        $backgrounds = Background::all();

        return view('settings.backgrounds', [
            'backgrounds' => $backgrounds
        ]);
    }

    public function newBackground(Request $request)
    {
        $name = $request->input('name');
        $red = $request->input('red');
        $green = $request->input('green');
        $blue = $request->input('blue');

        if(!($name && $red && $green && $blue)){
            abort(400);
        }

        if(!(is_integer((int)$name) && is_integer((int)$green) && is_integer((int)$blue))){
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

    public function editBackground(Request $request, Background $background)
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

    public function deleteBackground(Request $request, Background $background)
    {
        $background->delete();

        return redirect()->back();
    }
}
