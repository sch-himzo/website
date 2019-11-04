@extends('layouts.main')

@section('title','Pulcsi és Foltmékör')

@section('index.active','active')

@section('jumbotron')
    <div class="jumbotron">
        <div class="container">
            <h1>Pulcsi és Foltmékör</h1>
            <p>Üdvözöljük a Pulcsi és Foltmékör weboldalán! Itt leadhatja folt rendelését</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route('orders.new') }}">Rendelés &raquo;</a></p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
    </div>
@endsection
