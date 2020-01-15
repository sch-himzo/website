@extends('layouts.main')

@section('title','Pulcsi leltár')

@section('content')
    <h1 class="page-header with-description">Pulcsi leltár</h1>
    <h2 class="page-description">
        <a href="{{ route('jumpers.index') }}">Vissza</a>
    </h2>

    <form action="{{ route('jumpers.save') }}" method="POST" class="form-inline">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pulcsik</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="text-align:right;">Színek</th>
                                @foreach($sizes as $size)
                                    <th style="text-align:center;">{{ $size }}</th>
                                @endforeach
                            </tr>
                                @foreach($colors as $color)
                                <tr>
                                    <th style="text-align:right;">{{ \App\Models\JumperType::getColor($color) }}</th>
                                    @foreach($sizes as $size)
                                        <td style="text-align:center;">
                                            @if(array_key_exists($color,$jumpers) && array_key_exists($size,$jumpers[$color]))
                                                <input min="0" style="width:60px; @if($jumpers[$color][$size]->count==0) background-color:rgba(255,150,150,1); @elseif($jumpers[$color][$size]->count<5) background-color:rgba(255,255,102,1) @else background-color:rgba(150,255,150,1) @endif" class="form-control" type="number" name="count_{{ $color . "_" . $size }}" id="count_{{ $color . "_" . $size }}" aria-label="{{ $color . "_" . $size }}" value="{{ $jumpers[$color][$size]->count }}">
                                            @else
                                                <input min="0" style="width:60px; background-color:rgba(255,150,150,1)" size="2" class="form-control" type="number" name="count_{{ $color . "_" . $size }}" aria-label="{{ $color . "_" . $size }}" value="0" id="count_{{ $color . "_" . $size }}">
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Műveletek</h3>
                    </div>
                    <div class="panel-body">
                        <a href="{{ route('jumpers.edit') }}" class="btn btn-block btn-default">
                            <i class="fa fa-refresh"></i> Visszaállítás
                        </a>
                        <button type="submit" class="btn btn-block btn-primary">
                            <i class="fa fa-save"></i> Mentés
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        @foreach($colors as $color)
            @foreach($sizes as $size)
                $('#count_{{ $color . '_' . $size }}').on('keyup click paste', function(){
                    if($('#count_{{ $color . '_' . $size }}').val()===0) {
                        $('#count_{{ $color . '_' . $size }}').css('background-color','rgba(255,150,150,1)');
                    }else if($('#count_{{ $color . '_' . $size }}').val()<5) {
                        $('#count_{{ $color . '_' . $size }}').css('background-color','rgba(255,255,102,1)');
                    }else {
                        $('#count_{{ $color . '_' . $size }}').css('background-color','rgba(150,255,150,1)');
                    }
                });
            @endforeach
        @endforeach
    </script>
@endsection
