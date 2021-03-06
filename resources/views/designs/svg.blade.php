<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 {{ $width }} {{ $height }}">
    @if($design->background!=null)
        <rect width="{{ $width }}" height="{{ $height }}" style="fill:rgb({{ $design->background->red }}, {{ $design->background->green }}, {{ $design->background->blue }});"></rect>
    @else
        <rect width="{{ $width }}" height="{{ $height }}" style="fill:rgb(255, 255, 255);"></rect>
    @endif
    @foreach($stitches as $id => $color)
        @if($design->colors->count()==0)
            <g id="color_{{ $id }}" style="stroke:#000000; stroke-width:2;">
        @else
            <g id="color_{{ $id }}" style="stroke:{{ $colors[$id] }}; stroke-width:2;">
        @endif
        @foreach($color as $stitch)
                <line x1="{{ $stitch[0][0]+abs($x_offset)+5 }}" x2="{{ $stitch[1][0]+abs($x_offset)+5 }}" y1="{{ $stitch[0][1]+abs($y_offset)+5 }}" y2="{{ $stitch[1][1]+abs($y_offset)+5 }}"></line>
        @endforeach
            </g>
    @endforeach
</svg>
