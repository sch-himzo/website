<?php

namespace App\Http\Controllers\API;

use App\Events\MachineDST;
use App\Events\MachineUpdate;
use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignGroup;
use App\Models\Machine;
use App\Models\Setting;
use App\Parser\DSTParser;
use App\Parser\ParserInterface;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;

class MachineController extends Controller
{
    const STATE_STOP_SWITCH = 0;
    const STATE_NEEDLE_STOP = 1;
    const STATE_THREAD_BREAK = 2;
    const STATE_MACHINE_ERROR = 3;
    const STATE_END = 4;
    const STATE_RUNNING = 68;

    /** @var ParserInterface $dstParser */
    private $dstParser;

    protected static $machine_states = [
        0 => 'stop_switch',
        1 => 'needle_stop',
        2 => 'thread_break',
        3 => 'machine_error',
        4 => 'end',
        68 => 'running'
    ];

    public function __construct(DSTParser $dstParser)
    {
        $this->dstParser = $dstParser;
    }

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

        $dst = $this->dstParser->parse($design);

        $stitches = json_encode($dst->getStitches());
        $width = $dst->getCanvasWidth();
        $height = $dst->getCanvasHeight();
        $xOffset = $dst->getMinVerticalPosition();
        $yOffset = $dst->getMaxVerticalPosition();

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
        $machine->total_stitches = $dst->getStitchCount();
        $machine->design_width = $width;
        $machine->design_height = $height;
        $machine->x_offset = $xOffset;
        $machine->state = 0;
        $machine->y_offset = $yOffset;
        $machine->current_stitch = 0;
        $machine->seconds_passed = 0;
        $machine->save();

        event(new MachineDST());

        return response()->json('200 Response OK');
    }

    public function updateStatus(Request $request)
    {
        $state = $request->input('state');
        $stitches = $request->input('stitches');
        $designs = $request->input('designs');
        $current_design = $request->input('current_design');

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

        if($state==0){
            $machine->current_stitch = $machine->total_stitches;
        }elseif($stitches!=null && $current_design!=null && $designs!=null){
            if($stitches!=$machine->current_stitch && $state == 1){
                $seconds_passed = time()-strtotime($machine->updated_at);
                $machine->seconds_passed += $seconds_passed;
            }
            $machine->current_stitch = max(0, $stitches);
            $machine->current_design = $current_design;
            $machine->design_count = $designs;
        }elseif($stitches!=null){
            if($stitches!=$machine->current_stitch){
                $seconds_passed = time()-strtotime($machine->updated_at);
                $machine->seconds_passed += $seconds_passed;
            }
            $machine->current_stitch = max(0, $stitches);
        }

        if($machine->current_stitch>$machine->total_stitches && $machine->design_count==$machine->current_design){
            $machine->current_stitch = $machine->total_stitches;
            $machine->state = 0;
        }
        $machine->save();

        event(new MachineUpdate($machine));

        return response()->json('200 Response OK');
    }

    public function getStatus($machine_key)
    {
        if($machine_key!=env("MACHINE_KEY")) {
            abort(401);
        }

        $machine = Machine::find(Setting::where('name','current_machine')->first()->setting);

        return response()->json([
            'current_stitch' => $machine->current_stitch,
            'current_design' => $machine->current_design,
            'total_stitches' => $machine->total_stitches,
            'total_designs' => $machine->design_count,
            'status' => $machine->getState(),
            'state' => $machine->state
        ]);
    }
}
