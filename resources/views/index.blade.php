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
    <div class="row">
    </div>
@endsection
