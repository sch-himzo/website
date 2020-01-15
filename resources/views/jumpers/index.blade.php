@extends('layouts.main')

@section('title','Pulcsik')

@section('content')
    <h1 class="page-header with-description">Pulcsik</h1>
    <h2 class="page-description">Rendelhető pulcsik</h2>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Pulcsik</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th style="text-align:right;">Szín</th>
                            @foreach($size_count as $key => $size)
                                @if($size!=0)
                                    <th style="text-align:center; width:75px;">{{ $key }}</th>
                                @endif
                            @endforeach
                        </tr>
                        @foreach($jumpers as $key2 => $color)
                            <tr>
                                <th style="text-align:right;">{{ \App\Models\JumperType::getColor($key2) }}</th>
                                @foreach($size_count as $key => $size)
                                    @if($size!=0 && array_key_exists($key,$color))
                                        <td @if($color[$key]->count!=0) id="jumper_{{ $key2 . '_' . $key }}" @endif style="text-align:center;">{{ $color[$key]->count }} db</td>
                                    @elseif($size!=0 && !array_key_exists($key,$color))
                                        <td style="text-align:center;">0 db</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
                @if(Auth::check() && Auth::user()->role_id>2)
                    <div class="panel-footer">
                        <a href="{{ route('jumpers.edit') }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit"></i> Leltár módosítása
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if(Auth::check())
        <script>
            @foreach($sizes as $size)
            @foreach($colors as $color)
                @php
                    $color = str_replace('-','_',$color);
                @endphp
                let order_button_{{ $color."_".$size }} = "&nbsp;&nbsp;<button style='font-size:10px;' class='btn btn\-success btn-xs' type='button'><i class='fa fa-plus'></i></button>&nbsp;&nbsp;";
                let original_{{ $color."_".$size }} = $('#jumper_{{ $color."_".$size }}').html();
            $('#jumper_{{ $color."_".$size }}').mouseenter( function(){
                $('#jumper_{{ $color."_".$size }}').html(order_button_{{ $color."_".$size }});
                console.log('asd');
            });
            $('#jumper_{{ $color."_".$size }}').mouseleave(function(){
                $('#jumper_{{ $color."_".$size }}').html(original_{{ $color."_".$size }});
            });
            @endforeach
            @endforeach
        </script>
    @endif
@endsection
