<?php

namespace App\Events;

use App\Models\Machine;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MachineUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;

    /**
     * MachineUpdate constructor.
     * @param Machine $machine
     *
     * @return void
     */
    public function __construct(Machine $machine)
    {
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

        $this->message = [
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
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['machine-update'];
    }

    public function broadcastAs()
    {
        return 'machine-update';
    }
}
