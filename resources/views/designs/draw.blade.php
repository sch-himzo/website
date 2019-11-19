@extends('layouts.main')

@section('title','DST Kirajzolás')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-push-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Színválasztás</h3>
                </div>
                <form action="{{ route('designs.colors', ['design' => $design]) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="colors" value="{{ $color_count }}">
                    <div class="panel-body">
                        <div class="color-select">
                            @if($design->colors->count()==0)
                            @for($i = 0; $i<$color_count; $i++)
                                <div class="color">
                                    {{ $i+1 }}. szín:
                                    <input min="0" max="255" class="form-control" style="width:auto; display:inline;" size="2" placeholder="R" id="r_{{ $i }}" name="r_{{ $i }}" type="number">
                                    <input min="0" max="255" class="form-control" style="width:auto; display:inline;" size="2" placeholder="G" id="g_{{ $i }}" name="g_{{ $i }}" type="number">
                                    <input min="0" max="255" class="form-control" style="width:auto; display:inline;" size="2" placeholder="B" id="b_{{ $i }}" name="b_{{ $i }}" type="number">
                                </div>
                            @endfor
                            @else
                                <?php $i = 0; ?>
                                @foreach($design->colors as $color)
                                    <div class="color">
                                        <?= $i+1 ?>. szín:
                                        <input value="{{ $color->red }}" min="0" max="255" class="form-control" style="width:auto; display:inline;" size="2" placeholder="R" id="r_{{ $i }}" name="r_{{ $i }}" type="number">
                                        <input value="{{ $color->green }}" min="0" max="255" class="form-control" style="width:auto; display:inline;" size="2" placeholder="G" id="g_{{ $i }}" name="g_{{ $i }}" type="number">
                                        <input value="{{ $color->blue }}" min="0" max="255" class="form-control" style="width:auto; display:inline;" size="2" placeholder="B" id="b_{{ $i }}" name="b_{{ $i }}" type="number">
                                    </div>
                                    <?php $i++; ?>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="submit" value="Mentés" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="svg" style="width:{{ $width }}px;">
        <svg style="margin:auto;" width="{{ $width }}" height="{{ $height }}">
            @foreach($stitches as $id => $color)
                @if($design->colors->count()==0)
                <g id="color_{{ $id }}" style="stroke:rgb(0,0,0)">
                @else
                <g id="color_{{ $id }}" style="stroke:rgb({{ $design->colors->where('number',$id)->first()->red }},{{ $design->colors->where('number',$id)->first()->green }},{{ $design->colors->where('number',$id)->first()->blue }});">
                @endif
                    @foreach($color as $stitch)
                        <line x1="{{ $stitch[0][0]+$width/2 }}" x2="{{ $stitch[1][0]+$width/2 }}" y1="{{ $stitch[0][1]+$height/2 }}" y2="{{ $stitch[1][1]+$height/2 }}" style="stroke-width:1;"></line>
                    @endforeach
                </g>
            @endforeach
        </svg>
    </div>
@endsection

@section('scripts')
    <script>
        @for($i = 0; $i<$color_count; $i++)
            $('#r_{{ $i }}').on('keyup paste click', function(){
                r = $('#r_{{ $i }}').val();
                g = $('#g_{{ $i }}').val();
                b = $('#b_{{ $i }}').val();
                if(r===''){
                    r = 0;
                }
                if(g === ''){
                    g = 0;
                }
                if(b === ''){
                    b = 0;
                }
                console.log(r);
                $('#color_{{ $i }}').attr('style','stroke:rgb(' + r + ',' + g + ',' + b + ')');
            });
        $('#g_{{ $i }}').on('keyup paste click', function(){
            r = $('#r_{{ $i }}').val();
            g = $('#g_{{ $i }}').val();
            b = $('#b_{{ $i }}').val();
            if(r===''){
                r = 0;
            }
            if(g === ''){
                g = 0;
            }
            if(b === ''){
                b = 0;
            }
            console.log(r);
            $('#color_{{ $i }}').attr('style','stroke:rgb(' + r + ',' + g + ',' + b + ')');
        });
        $('#b_{{ $i }}').on('keyup paste click', function(){
            r = $('#r_{{ $i }}').val();
            g = $('#g_{{ $i }}').val();
            b = $('#b_{{ $i }}').val();
            if(r===''){
                r = 0;
            }
            if(g === ''){
                g = 0;
            }
            if(b === ''){
                b = 0;
            }
            console.log(r);
            $('#color_{{ $i }}').attr('style','stroke:rgb(' + r + ',' + g + ',' + b + ')');
        });
        @endfor
    </script>
@endsection
