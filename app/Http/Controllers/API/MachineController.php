<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

        $setting = Setting::where('name','machine_state')->first();

        $setting->setting = $state;
        $setting->save();

        if($stitches){
            $stitch_setting = Setting::where('name','machine_stitches')->first();
            if($stitch_setting==null){
                $stitch_setting = new Setting();
                $stitch_setting->name='machine_stitches';
                $stitch_setting->setting=0;
                $stitch_setting->description='Hányadik öltésnél jár a hímzőgép';
                $stitch_setting->save();
            }
            $stitch_setting->setting = $stitches;
            $stitch_setting->save();
        }

        return response()->json(['ok']);
    }
}
