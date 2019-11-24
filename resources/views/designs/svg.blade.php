<svg>
    @if($design->background!=null)
        <rect width="{{ $width }}" height="{{ $height }}" style="fill:rgb({{ $design->background->red }}, {{ $design->background->green }}, {{ $design->background->blue }})"></rect>
    @endif
    @foreach($stitches as $id => $color)
        @if($design->colors->count()==0)
            <g id="color_{{ $id }}" style="stroke:rgb(0,0,0)">
        @else
            <g id="color_{{ $id }}" style="stroke:rgb({{ $design->colors->where('number',$id)->first()->red }}, {{ $design->colors->where('number',$id)->first()->green }}, {{ $design->colors->where('number',$id)->first()->blue }});">
        @endif
        @foreach($color as $stitch)
                <line x1="{{ $stitch[0][0]+abs($x_offset)+5 }}" x2="{{ $stitch[1][0]+abs($x_offset)+5 }}" y1="{{ $stitch[0][1]+abs($y_offset)+5 }}" y2="{{ $stitch[1][1]+abs($y_offset)+5 }}" style="stroke-width:1;"></line>
        @endforeach
            </g>
    @endforeach
</svg>