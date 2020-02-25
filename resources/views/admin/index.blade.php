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
    <div class="row">
        <div class="col-md-3">
            <a class="btn-push btn btn-lg btn-block btn-default" href="{{ route('admin.misc.index') }}">
                <i class="fa fa-question"></i> Egyéb
            </a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-push btn-lg btn-block btn-default" href="{{ route('admin.backgrounds.index') }}">
                <i class="fa fa-scroll"></i> Kordurák
            </a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-push btn-lg btn-block btn-default" href="{{ route('admin.news.index') }}">
                <i class="fa fa-newspaper-o"></i> Hírek
            </a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-push btn-lg btn-block btn-default" href="{{ route('admin.emails.index') }}">
                <i class="fa fa-envelope"></i> Emailek
            </a>
        </div>
    </div>
@endsection
