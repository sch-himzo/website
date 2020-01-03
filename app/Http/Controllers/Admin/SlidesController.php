<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlidesController extends Controller
{
    public function index()
    {
        $slides = Slide::all()->sortBy('number');

        return view('admin.slides.index', [
            'slides' => $slides
        ]);
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', [
            'slide' => $slide
        ]);
    }

    public function save(Request $request, Slide $slide)
    {
        $title = $request->input('title');
        $message = $request->input('message');
        $image = $request->input('image');

        $slide->title = $title;
        $slide->message = $message;
        $slide->image = $image;
        $slide->save();

        return redirect()->route('admin.slides.index');
    }

    public function up(Slide $slide)
    {
        $number = $slide->number;

        if($slide->number==1){
            return redirect()->back();
        }

        $prev_slide = Slide::where('number',$number-1)->first();

        $prev_slide->number = $prev_slide->number + 1;
        $prev_slide->save();

        $slide->number = $slide->number-1;
        $slide->save();

        return redirect()->back();
    }

    public function down(Slide $slide)
    {
        $number = $slide->number;

        if($slide->number == Slide::count('id')){
            return redirect()->back();
        }

        $next_slide = Slide::where('number',$number+1)->first();

        $next_slide->number = $slide->number;
        $next_slide->save();

        $slide->number = $next_slide->number+1;
        $slide->save();

        return redirect()->back();
    }

    public function delete(Slide $slide)
    {
        $number = $slide->number;

        $slide->delete();

        $after = Slide::where('number','>',$number)->get();

        if($after!=null){
            foreach($after as $after_slide)
            {
                $after_slide->number = $after_slide->number-1;
                $after_slide->save();
            }
        }

        return redirect()->back();
    }

    public function create(Request $request)
    {
        $title = $request->input('title');
        $message = $request->input('message');
        $image = $request->input('image');

        $last_slide = Slide::all()->sortByDesc('number')->first();
        if($last_slide==null){
            $number = 1;
        }else{
            $number = $last_slide->number + 1;
        }

        $slide = new Slide();
        $slide->title = $title;
        $slide->message = $message;
        $slide->image = $image;
        $slide->number = $number;
        $slide->save();

        return redirect()->back();
    }
}
