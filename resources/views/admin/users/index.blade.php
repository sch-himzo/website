@extends('layouts.main')

@section('title','Admin - Felhasználók')

@section('content')
    <h1 class="page-header with-description">Felhasználók</h1>
    <h2 class="page-description">
        <a href="{{ route('admin.index') }}">Vissza</a>
    </h2>
    <div class="row">
        <div class="col-md-12">
            {{ $users->links() }}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Felhasználók</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th style="text-align:center;">Email</th>
                            <th style="text-align:center;">Jogosultság</th>
                            <th style="text-align:center;">Email visszaigazolva</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.users.user', ['user' => $user->id]) }}">{{ $user->name }}</a>
                                </td>
                                <td align="center">{{ $user->email }}</td>
                                <td align="center">{{ $user->role->name }}</td>
                                <td align="center">
                                    @if($user->activated)
                                        <i class="fa fa-check" data-toggle="tooltip" title="Aktiválva"></i>
                                    @else
                                        <i class="fa fa-times" data-toggle="tooltip" title="Aktiválásra vár"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{ $users->links() }}
        </div>
    </div>
@endsection
