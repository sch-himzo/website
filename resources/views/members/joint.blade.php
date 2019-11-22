@extends('layouts.members')

@section('title','Nagy közös projektek')
@section('page-title')
    <h1 class="page-header">Nagy közös projektek</h1>
@endsection

@section('members.active','active')
@section('members.joint.active','active')

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
                    <th>Határidő</th>
                    <th>Státusz</th>
                </tr>
                @if($orders==null)
                    <tr>
                        <td colspan="4" align="center">
                            <i class="fa fa-frown"></i> <i>Nincs most közös projekt</i>
                        </td>
                    </tr>
                @else
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.view', ['order' => $order]) }}">{{ $order->title }}</a>
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
                                @if($order->time_limit)
                                    {{ \Carbon\Carbon::create($order->time_limit)->diffForHumans() }}
                                @else
                                    <i>Nincs</i>
                                @endif
                            </td>
                            <td>{{ $order->getStatusInternal() }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
@endsection
