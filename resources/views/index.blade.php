@extends('layouts.main')

@section('title','Pulcsi és Foltmékör')

@section('index.active','active')

@section('jumbotron')
    <div class="jumbotron" style="margin-top:-20px;">
        <div class="container">
            <h1>Pulcsi és Foltmékör</h1>
            <p>Üdvözöljük a Pulcsi és Foltmékör weboldalán! Itt leadhatja folt rendelését</p>
            @if(Auth::check())
            <p><a class="btn btn-primary btn-lg" href="{{ route('orders.new') }}">Rendelés &raquo;</a></p>
            @else
            <p><a class="btn btn-primary btn-lg" href="#" data-toggle="modal" data-target="#login_modal">Rendelés &raquo;</a></p>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <input type="hidden" name="users_url" id="users_url" value="{{ route('getUsers') }}">
    <input type="hidden" name="current_user_id" id="current_user_id" value="@if(Auth::check()) {{ Auth::user()->id }} @else {{ false }} @endif">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kik vannak most hímzőben?</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="users_table">
                    </table>
                </div>
                @if(Auth::check() && Auth::user()->role_id>1)
                    <div class="panel-footer" id="btn-container">

                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/currently_in.js') }}"></script>
@endsection
