<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignGroup;
use App\Models\Machine;
use App\Models\Setting;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;

class MachineController extends Controller
{
    protected static $machine_states = [
        0 => 'stop_switch',
        1 => 'needle_stop',
        2 => 'thread_break',
        3 => 'machine_error',
        4 => 'end',
        68 => 'running'
    ];

    public function updateDST(Request $request)
    {
        $dst_file = $request->file('dst');

        $name = time() . Str::random(5) . ".dst";
        $path = "images/uploads/designs/machine/";

        Storage::disk()->put($path.$name, File::get($dst_file));

        $setting = Setting::all()->where('name','machine_design_group')->first();

        if($setting==null){
            $setting = new Setting();
            $setting->name = 'machine_design_group';
            $setting->description = "Az a mappa ahova a gépből kiszedett designok kerülnek";

            $design_group = new DesignGroup();
            $design_group->name = 'Gépi DST-k';
            $design_group->owner_id = 1;
            $design_group->save();

            $setting->setting = $design_group->id;
            $setting->save();
        }else{
            $design_group = DesignGroup::find($setting->setting);
        }

        $design = new Design();
        $design->design_group_id = $design_group->id;
        $design->image = "machine/$name";
        $design->name = "Machine design #$design->id";
        $design->save();

        $parsed = \App\Http\Controllers\DSTController::parseDST($design);

        $stitches = json_encode($parsed[0]);
        $width = $parsed[2];
        $height = $parsed[1];
        $xoffset = $parsed[3];
        $yoffset = $parsed[4];

        $setting = Setting::where('name','current_machine')->first();

        if($setting==null){
            $machine = Machine::all()->first();

            if($machine==null){
                $machine = new Machine();
                $machine->save();
            }

            $setting = new Setting();
            $setting->name = "current_machine";
            $setting->setting = $machine->id;
            $setting->description = "Az aktuális gép";
            $setting->save();
        }else{
            $machine = Machine::find($setting->setting);
        }

        $machine->current_dst = $stitches;
        $machine->design_id = $design->id;
        $machine->total_stitches = $design->stitch_count;
        $machine->design_width = $width;
        $machine->design_height = $height;
        $machine->x_offset = $xoffset;
        $machine->y_offset = $yoffset;
        $machine->current_stitch = 0;
        $machine->save();

        return response()->json($stitches);
    }

    public function updateStatus(Request $request)
    {
        $state = $request->input('state');
        $stitches = $request->input('stitches');

        $setting = Setting::where('name','current_machine')->first();

        if($setting==null){
            $machine = Machine::all()->first();

            if($machine==null){
                $machine = new Machine();
                $machine->save();
            }

            $setting = new Setting();
            $setting->name = "current_machine";
            $setting->setting = $machine->id;
            $setting->description = "Az aktuális gép";
            $setting->save();

        }

        $machine = Machine::all()->find($setting->setting);
        $machine->state = $state;
        $machine->current_stitch = $stitches;
        $machine->total_stitches = 1;
        $machine->save();

        return response()->json(['ok']);
    }
}
