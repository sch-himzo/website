@extends('layouts.main')

@section('title','Admin')

@section('content')
    <h1 class="page-header">Admin főoldal</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Felhasználók</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th style="text-align:center;">Email</th>
                            <th style="text-align:right;">Jogosultság</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="{{ route('admin.user', ['user' => $user]) }}">{{$user->name}}</a></td>
                                <td align="center">{{$user->email}}</td>
                                <td align="right">{{$user->role->name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
