@extends('layouts.main')

@section('title','Admin')

@section('content')
    <h1 class="page-header">Admin főoldal</h1>
    <div class="row">
        <div class="col-md-3">
            <a class="btn btn-lg btn-block btn-default" href="{{ route('admin.users.index') }}">
                <i class="fa fa-user"></i> Felhasználók
            </a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-lg btn-block btn-default" href="{{ route('admin.galleries.index') }}">
                <i class="fa fa-images"></i> Galériák
            </a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-lg btn-block btn-default" href="{{ route('admin.designs.index') }}">
                <i class="fa fa-pencil-ruler"></i> Tervek
            </a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-lg btn-block btn-default" href="{{ route('admin.slides.index') }}">
                <i class="fa fa-home"></i> Főoldal
            </a>
        </div>
    </div>
@endsection
