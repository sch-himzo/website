@extends('layouts.main')

@section('title','Aktiváld felhasználód')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Aktiváld felhasználód!</h3>
        </div>
        <div class="panel-body">
            <p>Köszönjük, hogy regisztráltál weboldalunkon!</p>
            <p>Küldtünk neked egy emailt a(z) <b>{{ Auth::user()->email }}</b> email címre egy aktiváló linkkel.</p>
        </div>
    </div>
@endsection
