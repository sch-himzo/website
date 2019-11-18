@extends('layouts.main')

@section('title','Szerkesztés - '.$slide->title)

@section('content')
    <h1 class="page-header">Slide szerkesztése &raquo; {{ $slide->title }} &raquo; <a href="{{ route('settings.index') }}">Vissza</a></h1>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Szerkesztés</h3>
        </div>
        <form action="{{ route('settings.index.slides.save', ['slide' => $slide]) }}" method="POST">
            {{ csrf_field() }}
            <div class="panel-body">
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-addon" for="title">Cím<span class="required">*</span></label>
                        <input type="text" name="title" id="title" value="{{ $slide->title }}" placeholder="Cím" required class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-addon" for="message">Üzenet<span class="required">*</span></label>
                        <textarea class="form-control" required name="message" id="message">{!! $slide->message !!}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-addon" for="image">Kép<span class="required">*</span></label>
                        <input type="text" value="{{ $slide->image }}" name="image" id="image" required class="form-control" placeholder="Kép">
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" class="btn btn-primary" value="Mentés">
                <a href="{{ route('settings.index') }}" class="btn btn-default">Mégse</a>
            </div>
        </form>
    </div>
@endsection
