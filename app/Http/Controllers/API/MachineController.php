<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    public function updateStatus(Request $request, $machine_key, $code, $stitches)
    {
        if(!key_exists($code,static::$machine_states)){
            return response()->json(['error' => 'unknown machine state']);
        }



        return response()->json(['ok']);
    }
}
