@extends('layouts.members')

@section('members.active','active')

@section('members.index.active','active')

@section('title','Tag főoldal')

@section('page-title')
    <h1 class="page-header">Irányítópult</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Közelgő határidejű rendelések</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th>Határidő</th>
                            <th>Körtagok</th>
                        </tr>
                        @foreach($time_limit as $order)
                            @if($order->assigned_users_count!=0)
                                <?php $i = 0; ?>
                                @foreach($order->assignedUsers as $user)
                                    <?php $i++; ?>
                                    @if($i==1)
                                        <tr>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                <a href="{{ route('orders.view', ['order' => $order]) }}">{{ $order->title }}</a>
                                            </td>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                {{ \Carbon\Carbon::create($order->time_limit)->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
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
                                        <a href="{{ route('orders.view', ['order' => $order]) }}">{{ $order->title }}</a>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::create($order->time_limit)->diffForHumans() }}
                                    </td>
                                    <td>
                                        <i>Nincs hozzárendelve senki</i>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nemrég elkészült rendelések</h3>
                </div>
                <div class="table table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th>Elkészült</th>
                            <th>Körtagok</th>
                        </tr>
                        @foreach($recent as $order)
                            @if($order->assigned_users_count!=0)
                                <?php $i = 0; ?>
                                @foreach($order->assignedUsers as $user)
                                    <?php $i++; ?>
                                    @if($i==1)
                                        <tr>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                <a href="{{ route('orders.view', ['order' => $order]) }}">{{ $order->title }}</a>
                                            </td>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                {{ $order->updated_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
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
                                        <a href="{{ route('orders.view', ['order' => $order]) }}">{{ $order->title }}</a>
                                    </td>
                                    <td>
                                        {{ $order->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <i>N/A</i>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
