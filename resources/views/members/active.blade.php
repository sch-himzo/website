@extends('layouts.members')

@section('title','Aktív rendelések')
@section('page-title')
    <h1 class="page-header">Aktív rendelések</h1>
@endsection

@section('members.active','active')
@section('members.active.active','active')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Rendelések</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Név</th>
                    <th>Megrendelő</th>
                    <th>Rendelés időpontja</th>
                    <th>Hozzárendelt körtagok</th>
                    @if(Auth::user()->role_id>4)
                        <th>Műveletek</th>
                    @endif
                </tr>
                @if($orders == null)
                    <tr>
                        <td colspan="5" align="center">Nincs aktív rendelés</td>
                    </tr>
                @else
                    @foreach($orders as $order)
                        @if($order->assigned_users_count!=0)
                            <?php $i = 0; ?>
                            @foreach($order->assignedUsers as $user)
                                <?php $i++; ?>
                                @if($i==1)
                                    <tr>
                                        <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                            <a href="{{ route('orders.groups.view', ['group' => $order]) }}">{{ $order->title }}</a>
                                        </td>
                                        <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                            @if($order->user!=null)
                                                {{ $order->user->name }} <i class="fa fa-check" data-toggle="tooltip" title="Regisztrált felhasználó"></i>
                                            @elseif($order->tempUser!=null)
                                                {{ $order->tempUser->name }} <i class="fa fa-exclamation-circle" data-toggle="tooltip" title="Nem létező felhasználó"></i>
                                            @else
                                                <i>N/A</i>
                                            @endif
                                        </td>
                                        <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                            {{ $order->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        @if(Auth::user()->role_id>4)
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                @if($order->joint_project)
                                                    <span data-toggle="tooltip" title="Nem nagy közös projekt">
                                                        <a class="btn btn-xs btn-danger" href="{{ route('orders.groups.joint', ['group' => $order]) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </span>
                                                @else
                                                    <span data-toggle="tooltip" title="Nagy közös projektté avatás">
                                                        <a class="btn btn-xs btn-success" href="{{ route('orders.groups.joint', ['group' => $order]) }}">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                                                    </span>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <a href="{{ route('orders.groups.view', ['group' => $order]) }}">{{ $order->title }}</a>
                                </td>
                                <td>
                                    @if($order->user!=null)
                                        {{ $order->user->name }} <i class="fa fa-check" data-toggle="tooltip" title="Regisztrált felhasználó"></i>
                                    @elseif($order->tempUser!=null)
                                        {{ $order->tempUser->name }} <i class="fa fa-exclamation-circle" data-toggle="tooltip" title="Nem létező felhasználó"></i>
                                    @else
                                        <i>N/A</i>
                                    @endif
                                </td>
                                <td>
                                    {{ $order->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    <i>N/A</i>
                                </td>
                                @if(Auth::user()->role_id>4)
                                    <td>
                                        @if($order->joint_project)
                                            <span data-toggle="tooltip" title="Nem nagy közös projekt">
                                                        <a class="btn btn-xs btn-danger" href="{{ route('orders.groups.joint', ['group' => $order]) }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </span>
                                        @else
                                            <span data-toggle="tooltip" title="Nagy közös projektté avatás">
                                                        <a class="btn btn-xs btn-success" href="{{ route('orders.groups.joint', ['group' => $order]) }}">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                                                    </span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>
@endsection
