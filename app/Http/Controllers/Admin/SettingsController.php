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
}
