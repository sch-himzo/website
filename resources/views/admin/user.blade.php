@extends('layouts.main')

@section('title','Admin')

@section('content')
    <h1 class="page-header">Felhasználó</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Felhasználó adatai</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Emailek engedélyezve</th>
                            <td>@if($user->allow_emails) Igen @else Nem @endif</td>
                        </tr>
                        <tr>
                            <th>Notik engedélyezve</th>
                            <td>@if(!$user->notifications_disabled) Igen @else Nem @endif</td>
                        </tr>
                        <tr>
                            <th>Jogosultság</th>
                            <td>
                                {{$user->role->name}}
                                @if($user->role->id == 6)
                                    <a href="{{ route('admin.user.unsetWebadmin', ['user' => $user]) }}" class="btn btn-xs btn-danger">
                                        <i class="fa fa-times"></i> Webadmin jog elvétele
                                    </a>
                                @else
                                    <a href="{{ route('admin.user.setWebadmin', ['user' => $user]) }}" class="btn btn-xs btn-success">
                                        <i class="fa fa-check"></i> Webadmin jog adása
                                    </a>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Felhasználó rendelései</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @if ( $orders->count() == 0)
                            <tr>
                                <td align="center">Nincs megrendelés :(</td>
                            </tr>
                        @else
                            <tr>
                                <th>Cím</th>
                                <th>Komment</th>
                                <th>Állapot</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td><a href="{{route('orders.view', ['group' => $order])}}">{{ $order->title }}</a></td>
                                    <td>{{ $order->comment }}</td>
                                    <td>{{ $order->getStatusClient() }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
