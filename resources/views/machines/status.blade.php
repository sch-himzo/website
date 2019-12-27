@extends('layouts.main')

@section('title','Gép állapota')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Állapot</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Állapot</th>
                            <td id="status">{{ $machine->getState() }}</td>
                        </tr>
                        <tr>
                            <th>Öltések</th>
                            <td id="stitches">{{ $machine->total_stitches."/".$machine->current_stitch }} öltés</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="progress" style="text-align:center; margin-bottom:0;">
                                    <div id="machine_progress_bar_status" class="{{ $machine->getProgressBar() }}" style="text-align:center;width:{{ round($machine->current_stitch*100/$machine->total_stitches) . "%;" }}">{{ round($machine->current_stitch/$machine->total_stitches,2)*100 . "%" }}</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="progress" style="text-align:center; margin-bottom:0;">
                                    <div id="machine_designs_progress_bar_status" class="progress-bar" style="width:{{ ($machine->current_design-1)*100/$machine->design_count . "%;" }}">{{ $machine->current_design-1 }}</div>
                                    <div id="machine_designs_progress_bar_current_status" class="progress-bar progress-bar-warning progress-bar-striped active" style="width:{{ 100/$machine->design_count . "%;" }}">Aktuális</div>
                                    <span id="machine_designs_left_status">{{ $machine->design_count-$machine->current_design }}</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Rajzolat</h3>
                </div>
                <div class="panel-body">
                    <svg style="background-color:white; margin:auto;" id="svg" class="svg" viewBox="0 0 {{ $machine->design_width }} {{ $machine->design_height }}" preserveAspectRatio="none">
                        <?php $i = 0; ?>
                        @foreach(json_decode($machine->current_dst) as $id => $color)
                            @foreach($color as $stitch)
                                <line id="stitch_<?= $i ?>" x1="{{ $stitch[0][0]+abs($machine->x_offset)+5 }}" x2="{{ $stitch[1][0]+abs($machine->x_offset)+5 }}" y1="{{ $stitch[0][1]+abs($machine->y_offset)+5 }}" y2="{{ $stitch[1][1]+abs($machine->y_offset)+5 }}" style="stroke-width:1.5; stroke:rgba(0,0,0, @if($i<$machine->current_stitch) 1 @else 0.2 @endif );"></line>
                                @if($i==$machine->current_stitch)
                                    <g id="crosshair" style="stroke-width:2; stroke:red" transform="translate({{ $stitch[0][0] + abs($machine->x_offset) + 5 }} {{ $stitch[0][1] + abs($machine->y_offset) + 5 }})">
                                        <line x1="0" x2="0" y1="3" y2="13"></line>
                                        <line x1="0" x2="0" y1="-3" y2="-13"></line>
                                        <line x1="3" x2="13" y1="0" y2="0"></line>
                                        <line x1="-3" x2="-13" y1="0" y2="0"></line>
                                    </g>
                                @endif
                                <?php $i++ ?>
                            @endforeach
                        @endforeach
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="current_stitch" value="{{ $machine->current_stitch }}">
    <input type="hidden" id="ajax_url" value="{{ route('machines.getStatus') }}">
    <input type="hidden" id="total_stitches" value="{{ $machine->total_stitches }}">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="current_state" value="{{ $machine->state }}">
@endsection

@section('scripts')
    <script>
        function update(){
            let current_stitch = $('#current_stitch').val();
            let url = $('#ajax_url').val();
            let total_stitches = $('#total_stitches').val();
            let token = $('#_token').val();
            let current_state = $('#current_state').val();

            $.ajax({
                url: url,
                method: "POST",
                data: {total_stitches: total_stitches, _token: token},
                dataType: 'json',
                success: function(e){
                    if('new_design' in e){
                        document.location.reload();
                    }else{
                        if(current_state!==e.state){
                            $('#status').html(e.status);
                            $('#current_state').val(e.state);
                        }
                        if(current_stitch!==e.current_stitch){
                            let percentage = Math.round(e.current_stitch*10000/e.total_stitches)/100;
                            percentage += "%";
                            $('#machine_progress_bar_status').css('width',percentage);
                            $('#machine_progress_bar_status').html(percentage);
                            $('#machine_progress_bar_status').attr('class',e.progress_bar);
                            if(e.current_design===e.total_designs){
                                $('#machine_designs_progress_bar_current_status').css('display','none');
                                $('#machine_designs_progress_bar_status').css('width','100%');
                                $('#machine_designs_progress_bar_status').html(e.total_designs + "/" + e.total_designs);
                            }else{
                                $('#machine_designs_progress_bar_current_status').css('display','block');
                                $('#machine_designs_progress_bar_status').css('width',(e.current_design-1)*100/e.total_designs + "%");
                                $('#machine_designs_progress_bar_status').html(e.current_design-1);
                                $('#machine_designs_left_status').html(e.total_designs-e.current_design);
                            }
                            $('#stitches').html(total_stitches + "/" + e.current_stitch + " öltés");
                            let x_transform = e.current_offset[0][0] + e.x_offset + 5;
                            let y_transform = e.current_offset[0][1] + e.y_offset + 5;
                            $('#crosshair').attr('transform', 'translate(' + x_transform + " " + y_transform + ")");

                            let diff = e.current_stitch-current_stitch;
                            if(diff>0){
                                for(let i=current_stitch; i<e.current_stitch; i++){
                                    $('#stitch_' + i).css('stroke','rgba(0,0,0,1)');
                                }
                            }else{
                                for(let i=current_stitch; i>e.current_stitch-1; i--){
                                    $('#stitch_' + i).css('stroke','rgba(0,0,0,0.2)');
                                }
                            }

                            $('#current_stitch').val(e.current_stitch);
                        }
                    }

                },
                error: function(e){
                    console.log(e);
                }
            });
        }

        setInterval(update, 2000);
    </script>
@endsection
