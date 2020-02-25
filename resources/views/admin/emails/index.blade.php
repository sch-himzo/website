@extends('layouts.main')

@section('title','Admin - Emailek')

@section('content')
    <h1 class="page-header with-description">Emailek</h1>
    <h2 class="page-description">
        <a href="{{ route('admin.index') }}">Vissza</a>
    </h2>

    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('admin.emails.sent') }}" class="btn btn-block btn-default btn-lg btn-push">
                <i class="fa fa-envelope-open"></i> Elküldött emailek
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.emails.unsent') }}" class="btn btn-block btn-default btn-lg btn-push">
                <i class="fa fa-envelope"></i> Elküldetlen emailek
            </a>
        </div>
    </div>
@endsection
