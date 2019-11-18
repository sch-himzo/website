@extends('layouts.main')

@section('title','Feltöltött képek szerkesztése')

@section('content')
    <h1 class="page-header with-description">Album szerkesztése</h1>
    <h2 class="page-description">{{ $album->name }}</h2>
    <form action="{{ route('albums.save', ['album' => $album, 'order' => $order]) }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="images" value="{{ $image_ids }}">
        <div class="row">
            @foreach($images as $image)
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a target="_blank" href="{{ route('images.get', ['image' => $image]) }}">
                                <img class="album-edit-image" src="{{ route('images.get', ['image' => $image]) }}" alt="">
                            </a>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="title_{{ $image->id }}">Cím<span class="required">*</span></label>
                                    <input type="text" name="title_{{ $image->id }}" class="form-control" id="title_{{ $image->id }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="description_{{ $image->id }}">Leírás<span class="required">*</span></label>
                                    <input type="text" name="description_{{ $image->id }}" class="form-control" id="description_{{ $image->id }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a class="btn btn-default" href="{{ route('albums.new', ['order' => $order]) }}"><i class="fa fa-arrow-left"></i> Vissza</a>
                        <button data-toggle="tooltip" title="Ha elmented a megrendelő kap egy emailt" type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Mentés
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
