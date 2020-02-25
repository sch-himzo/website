@extends('layouts.main')

@section('title','Aktiváld felhasználód')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Megerősítő email újraküldve!</h3>
        </div>
        <div class="panel-body">
            <p>Elküldtük a megerősítő emailt <b>{{ Auth::user()->email }}</b> email címre!</p>
        </div>
    </div>
@endsection
