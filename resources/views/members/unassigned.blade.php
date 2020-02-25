@extends('layouts.members')

@section('title','Elvállalatlan rendelések')

@section('members.active','active')

@section('members.unassigned.active','active')

@section('page-title')
    <h1 class="page-header">Elvállalatlan rendelések</h1>
@endsection

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
                    <th>Darabszám</th>
                    <th>Műveletek</th>
                </tr>
                @if(sizeof($orders)==0)
                    <tr>
                        <td colspan="6">
                            <i>Az összes rendelés vállalva van <i class="fa fa-smile"></i></i>
                        </td>
                    </tr>
                @endif
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('orders.groups.view', ['group' => $order]) }}">{{ $order->title }}</a>
                        </td>
                        <td>
                            @if($order->user!=null)
                                {{ $order->user->name }} <i data-toggle="tooltip" title="Regisztrált felhasználó" class="fa fa-check"></i>
                            @elseif($order->tempUser!=null)
                                {{ $order->tempUser->name }} <i data-toggle="tooltip" title="Nem létező felhasználó" class="fa fa-exclamation-circle"></i>
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
                        <td>{{ $order->count }}</td>
                        <td>
                            <span data-toggle="tooltip" title="Stipi">
                                <button data-toggle="modal" data-target="#set_{{ $order->id }}" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-fist-raised"></i>
                                </button>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @foreach($orders as $order)
        <div class="modal fade" id="set_{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Rendelés stipizése</h4>
                    </div>
                    <div class="modal-body">
                        <p>Biztosan stipized ezt a rendelést?</p>
                        <i>Pingetnin fog a rendszer ha közeleg a határideje, vagy ha sokáig nem foglalkozol vele</i>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse <i class="fa fa-frown"></i></button>
                        <a href="{{ route('orders.groups.assign', ['group' => $order]) }}" class="btn btn-primary"><i class="fa fa-check"></i> Igen!</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
