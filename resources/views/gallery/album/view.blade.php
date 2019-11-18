@extends('layouts.main')

@section('title','Album - '.$album->name)

@section('content')
    <h1 class="page-header with-description">Album megtekintése</h1>
    <h2 class="page-description">{{ $album->name }}</h2>
    <div class="row">
        @foreach($album->images as $image)
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a target="_bank" href="{{ route('images.get', ['image' => $image]) }}">
                            <img class="album-edit-image" src="{{ route('images.get',['image' => $image]) }}" alt="{{ $image->title }}">
                        </a>
                        <h3 class="panel-title">{{ $image->title }}</h3>
                        <p>{{ $image->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
