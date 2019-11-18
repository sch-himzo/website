@extends('layouts.main')

@section('galleries.active','active')

@section('title','Galériák')

@section('content')
    <h1 class="page-header">Albumok</h1>
    <div class="row">
        @if($albums->count()==0)
            <div class="col-md-4 col-md-push-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i>Nincs jelenleg album</i>
                        </h3>
                    </div>
                </div>
            </div>
        @endif
        @foreach($albums as $album)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $album->name }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
