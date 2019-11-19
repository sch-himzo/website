@extends('layouts.main')

@section('title','DST Kirajzolás')

@section('content')
    <svg style="margin:auto;" width="{{ $width }}" height="{{ $height }}">
        @foreach($stitches as $id => $color)
            <g id="color_{{ $id }}">
            @foreach($color as $stitch)
                <line x1="{{ $stitch[0][0]+$width/2 }}" x2="{{ $stitch[1][0]+$width/2 }}" y1="{{ $stitch[0][1]+$height/2 }}" y2="{{ $stitch[1][1]+$height/2 }}" style="stroke:rgb(0,0,0);stroke-width:1;"></line>
{{--                <circle cx="{{ $stitch[0][0]+$width/2 }}" cy="{{ $stitch[0][1]+$height/2 }}" r="2" stroke="red" stroke-width="1" fill="red" />--}}
            @endforeach
            </g>
        @endforeach
    </svg>
@endsection
