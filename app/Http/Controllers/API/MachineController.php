<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Setting;
use Illuminate\Http\Request;

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
