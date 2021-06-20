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
                            <th>Átlagos öltés/perc</th>
                            <td id="speed">@if($machine->seconds_passed!=0) {{ round($machine->current_stitch/$machine->seconds_passed*60) }} öltés/perc @endif</td>
                        </tr>
                        <tr>
                            <th>Becsült ETA</th>
                            <td id="ETA"></td>
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
                                    <div id="machine_designs_progress_bar_status" class="progress-bar" style="width:@if($machine->getState()!="Vége"){{ ($machine->current_design-1)*100/$machine->design_count . "%;" }} @else 100%; @endif">@if($machine->getState()!="Vége") {{ $machine->current_design-1 }} @else {{ $machine->design_count . "/" . $machine->design_count }} @endif</div>
                                    <div id="machine_designs_progress_bar_current_status" class="progress-bar progress-bar-warning progress-bar-striped active" style="width:@if($machine->getState()!="Vége") {{ 100/$machine->design_count . "%;" }} @else 0%; @endif">Aktuális</div>
                                    <span id="machine_designs_left_status">{{ $machine->design_count-$machine->current_design }}</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="alert alert-warning">
                <h4><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;Figyelem!</h4>
                <p style="text-align:justify;">Az itt feltüntetett öltésszám eltérhez a valóditól, mert a hímzőgép hozzáad öltéseket vágások előtt és után.</p>
            </div>
            <div class="alert alert-info">
                <h4><i class="fab fa-android"></i>&nbsp;&nbsp;Android App</h4>
                <p style="text-align:justify;">Letölthető a HímzőNot2 App, vigyázz vele, még nagyon indev:</p>
                <p><a href="{{ asset('downloads/himzo-noti.apk') }}" target="_blank">himzo-noti.apk</a></p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Rajzolat</h3>
                </div>
                <div class="panel-body">
                    @if($machine->total_stitches!=1022)
                        <svg style="@if (isset($machine->design) && isset($machine->design->background)) background-color:rgba({{ ($bg = $machine->design->background)->red }},{{ $bg->green }},{{ $bg->blue }},0.5); @else background-color:white; @endif margin:auto;" id="svg" class="svg" viewBox="0 0 {{ $machine->design_width }} {{ $machine->design_height }}" preserveAspectRatio="none">
                            <?php $i = 0; ?>
                            @foreach(json_decode($machine->current_dst) as $id => $color)

                                @if (isset($machine->design) && count($machine->design->colors) !== 0)
                                    <g id="color_{{ $id }}" style="stroke:{{ is_object($colorModel = $machine->design->colors->filter(function($c)use($id){return $c->number == $id;})->first()) ? $colorModel->red : 'rgb(0,0,0)' }}">
                                @else
                                    <g id="color" style="stroke:rgb(0,0,0);">
                                @endif

                                @foreach($color as $stitch)
                                    <line id="stitch_<?= $i ?>" x1="{{ $stitch[0][0]+abs($machine->x_offset)+5 }}" x2="{{ $stitch[1][0]+abs($machine->x_offset)+5 }}" y1="{{ $stitch[0][1]+abs($machine->y_offset)+5 }}" y2="{{ $stitch[1][1]+abs($machine->y_offset)+5 }}" style="stroke-width:1.5;  opacity:@if($i<$machine->current_stitch) 1 @else 0.2 @endif;"></line>
                                    @if($i==$machine->current_stitch)
                                        @php
                                            $asd = $stitch;
                                        @endphp
                                    @endif
                                    <?php $i++ ?>
                                @endforeach
                                @if (isset($machine->design) && count($machine->design->colors) !== 0)
                                    </g>
                                @endif
                            @endforeach
                                @if(!isset($asd))
                                    @php
                                        $asd = json_decode($machine->current_dst)[0][0];
                                    @endphp
                                @endif

                                <g id="crosshair" style="stroke-width:2; stroke:red" transform="translate({{ $asd[0][0] + abs($machine->x_offset) + 5 }} {{ $asd[0][1] + abs($machine->y_offset) + 5 }})">
                                    <line x1="0" x2="0" y1="3" y2="13"></line>
                                    <line x1="0" x2="0" y1="-3" y2="-13"></line>
                                    <line x1="3" x2="13" y1="0" y2="0"></line>
                                    <line x1="-3" x2="-13" y1="0" y2="0"></line>
                                </g>
                        </svg>
                    @endif
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
        channel.bind('machine-update', function(data){
            let total_stitches = $('#total_stitches').val();
            let current_stitch = $('#current_stitch').val();
            let current_state = $('#current_state').val();

            if(current_state!==data.message.state){
                $('#status').html(data.message.status);
                $('#current_state').val(data.message.state);
            }
            let percentage = Math.round(data.message.current_stitch * 10000 / data.message.total_stitches) / 100;
            percentage += "%";
            $('#machine_progress_bar_status').css('width', percentage);
            $('#machine_progress_bar_status').html(percentage);
            $('#machine_progress_bar_status').attr('class', data.message.progress_bar);
            if (data.message.current_design === data.message.total_designs && data.message.current_stitch===data.message.total_stitches) {
                $('#machine_designs_progress_bar_current_status').css('display', 'none');
                $('#machine_designs_progress_bar_status').css('width', '100%');
                $('#machine_designs_progress_bar_status').html(data.message.total_designs + "/" + data.message.total_designs);
            } else {
                let single_percentage = Math.round(10000/data.message.total_designs)/100;
                single_percentage += "%";
                $('#machine_designs_progress_bar_current_status').css('display', 'block');
                $('#machine_designs_progress_bar_current_status').css('width',single_percentage);
                $('#machine_designs_progress_bar_status').css('width', (data.message.current_design - 1) * 100 / data.message.total_designs + "%");
                $('#machine_designs_progress_bar_status').html(data.message.current_design - 1);
                $('#machine_designs_left_status').html(data.message.total_designs - data.message.current_design);
            }
            $('#speed').html("~" + Math.round(data.message.stitches_so_far/data.message.seconds_passed*60) + " öltés/perc");
            $('#ETA').html("~" + Math.round(data.message.eta) + " perc");
            $('#stitches').html(total_stitches + "/" + data.message.current_stitch + " öltés");
            let x_transform = data.message.current_offset[0][0] + data.message.x_offset + 5;
            let y_transform = data.message.current_offset[0][1] + data.message.y_offset + 5;
            $('#crosshair').attr('transform', 'translate(' + x_transform + " " + y_transform + ")");

            let diff = data.message.current_stitch - current_stitch;
            if (diff > 0) {
                for (let i = 0; i < data.message.current_stitch; i++) {
                    $('#stitch_' + i).css('opacity', '1');
                }
            } else {
                for (let i = data.message.total_stitches; i > data.message.current_stitch - 1; i--) {
                    $('#stitch_' + i).css('opacity', '0.2');
                }
            }

            $('#current_stitch').val(data.message.current_stitch);
        });
    </script>
@endsection
