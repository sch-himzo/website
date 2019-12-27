<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $slides = Slide::all()->sortBy('number');

        return view('index',[
            'slides' => $slides
        ]);
    }

    public function party()
    {
        if(session('party')=='on'){
            Session::put('party','off');
        }else{
            Session::put('party','on');
        }

        return redirect()->back();
    }

    public function indexLogin(Request $request)
    {
        $slides = Slide::all()->sortBy('number');

        return view('index',[
            'login' => 1,
            'slides' => $slides
        ]);
    }

    public function getUsers(Request $request)
    {
        $users_in_club = User::all()
            ->where('in_club','1')
            ->where('role_id','>','1')
            ->all();

        $users = [];
        $ids = [];

        if($users_in_club!=null){
            foreach($users_in_club as $user){
                $users[] = $user->name;
                $ids[] = $user->id;
            }
        }

        return response()->json([
            'users' => $users,
            'ids' => $ids
        ]);
    }

    public function machineStatus()
    {
        $setting = Setting::where('name','current_machine')->first();
        $machine = Machine::find($setting->setting);

        return view('machines.status', [
            'machine' => $machine
        ]);
    }

    public function getMachineStatus(Request $request)
    {

        $setting = Setting::where('name','current_machine')->first();

        $machine = Machine::find($setting->setting);

        $total_stitches = $request->input('total_stitches');
        $actual_total_stitches = $machine->total_stitches;

        $stitches = [];

        foreach(json_decode($machine->current_dst) as $color){
            foreach($color as $stitch){
                $stitches[] = $stitch;
            }
        }

        if($machine->current_stitch!=$machine->total_stitches){
            $current_offset = $stitches[$machine->current_stitch];
        }else{
            $current_offset = $stitches[0];
        }

        if($total_stitches!=$actual_total_stitches){
            return response()->json([
                'new_design' => true
            ]);
        }else{
            return response()->json([
                'state' => $machine->state,
                'current_stitch' => $machine->current_stitch,
                'status' => $machine->getState(),
                'current_offset' => $current_offset,
                'x_offset' => abs($machine->x_offset),
                'y_offset' => abs($machine->y_offset),
                'current_design' => $machine->current_design,
                'total_designs' => $machine->design_count,
                'progress_bar' => $machine->getProgressBar(),
                'total_stitches' => $machine->total_stitches
            ]);
        }
    }

    public function getProgressBar()
    {
        $setting = Setting::where('name','current_machine')->first();
        $machine = Machine::find($setting->setting);

        return response()->json([
            'state' => $machine->getState(),
            'progress_bar' => $machine->getProgressBar(),
            'current_stitch' => $machine->current_stitch,
            'total_stitches' => $machine->total_stitches,
            'current_design' => $machine->current_design,
            'total_designs' => $machine->design_count
        ]);
    }
}
