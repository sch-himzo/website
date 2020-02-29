@extends('layouts.main')

@section('title','Saját projektek')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-push-4">
            <div class="alert alert-warning alert-dismissable">
                <button class="close" type="button" data-dismiss="alert">&times;</button>
                <h4><i class="fa fa-exclamation-triangle"></i> Achtung!</h4>
                <p>Ez a szekció még fejlesztés alatt van, nyugodtan próbálgasd de ne számíts sokra <i class="fa fa-smile"></i></p>
            </div>
        </div>
    </div>
    <h1 class="page-header with-description">Saját projektek &raquo; <a href="{{ route('projects.create') }}" class="btn btn-lg btn-default"><i class="fa fa-plus"></i> Új projekt</a></h1>
    <h2 class="page-description">
        <a onclick="window.history.back()" href="#">Vissza</a>
    </h2>
    <div class="row">
        @if($projects->count() == 0)
            <div class="col-md-4 col-md-push-4">
                <div class="alert alert-info">
                    <h4><i class="fa fa-frown"></i> Nincs projekted feltöltve</h4>
                    <p>Nincs jelenleg feltöltve projekted <i class="fa fa-frown"></i> <a href="{{ route('projects.create') }}">Erre a linkre</a> kattintva tudsz újat létrehozni</p>
                </div>
            </div>
        @endif
        @foreach($projects as $project)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $project->name }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $projects->links() }}
    </div>
@endsection
