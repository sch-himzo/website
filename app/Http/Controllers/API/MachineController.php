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

        $setting = Setting::where('name','machine_state')->first();

        $setting->setting = $state;
        $setting->save();

        return response()->json(['ok']);
    }
}
