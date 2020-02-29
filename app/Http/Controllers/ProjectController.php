<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\DesignGroup;
use App\Models\Project;
use App\Models\Setting;
use Auth;
use File;
use Illuminate\Http\Request;
use Session;
use Storage;

class ProjectController extends Controller
{
    protected $allowed_extensions = [
        'png', 'jpg', 'gif', 'bmp', 'dst', 'art60', 'art80', 'webp', 'jpeg'
    ];

    public function index()
    {
        $projects = Project::where('user_id',Auth::id())->paginate(8);

        return view('projects.index',[
            'projects' => $projects
        ]);
    }

    public function create(Request $request, $step = 1)
    {
        $name = $request->input('name');
        $description = $request->input('description');

        if($name) {
            Session::put('name', $name);
        }else{
            $name = Session::get('name');
        }

        if($description) {
            Session::put('description', $description);
        }else{
            $description = Session::get('description');
        }

        if(($step == 2 || $step == 3) && !Session::exists('name')) {
            return redirect()->route('projects.create');
        }

        if($step == 3 && !Session::exists('description')) {
            return redirect()->route('projects.create', ['step' => 2]);
        }

        return view('projects.create', [
            'step' => $step,
            'name' => $name,
            'description' => $description
        ]);
    }

    public function save(Request $request)
    {
        if(!Session::exists('name')) {
            return redirect()->route('projects.create');
        }

        if(!Session::exists('description')) {
            return redirect()->route('projects.create', ['step' => 2]);
        }

        $name = Session::get('name');
        $description = Session::get('description');

        $files = $request->file('files');

        if($files == null) {
            return redirect()->route('projects.create', ['step' => 3]);
        }

        $user_design_group = Auth::user()->projectsGroup;

        $projects_group = Setting::where('name','projects_group')->first()->setting;

        if($user_design_group == null) {
            $user_design_group = new DesignGroup();
            $user_design_group->name = Auth::user()->name;
            $user_design_group->parent_id = $projects_group;
            $user_design_group->owner_id = Auth::id();
            $user_design_group->save();
        }

        $design_group = new DesignGroup();
        $design_group->parent_id = $user_design_group->id;
        $design_group->name = $name;
        $design_group->owner_id = Auth::id();
        $design_group->save();

        $project = new Project();
        $project->name = $name;
        $project->description = $description;
        $project->user_id = Auth::id();
        $project->design_group_id = $design_group->id;
        $project->save();

        foreach($files as $file) {
            $original_name = $file->getClientOriginalName();
            $original_extension = strtolower($file->getClientOriginalExtension());
            $file_size = $file->getSize()/1024/1024;

            if(!in_array($original_extension, $this->allowed_extensions)) {
                continue;
            }

            if($file_size>5) {
                continue;
            }

            $new_name = 'images/uploads/designs/' . $original_name;
            Storage::disk()->put($new_name, File::get($file));

            $design = new Design();
            $design->image = $original_name;
            $design->design_group_id = $design_group->id;
            $design->name = $original_name;
            $design->save();
        }

        Session::forget(['name','description']);

        return redirect()->route('projects.index');
    }
}
