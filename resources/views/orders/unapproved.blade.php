@extends('layouts.main')

@section('orders.unapproved.active','active')

@section('title','Elfogadásra váró rendelések')

@section('content')
    <h1 class="page-header">Elfogadásra váró rendelések</h1>
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Rendelés</th>
                    <th>Megrendelő</th>
                    <th>Határidő</th>
                    <th>Kép</th>
                    <th>Darabszám</th>
                    <th>Méret</th>
                    <th>Műveletek</th>
                </tr>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->title }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->time_limit }}</td>
                        <td>
                        <span data-toggle="tooltip" title="Kép megtekintése">
                            <a target="_blank" href="{{ route('orders.getImage', ['order' => $order]) }}" class="btn btn-xs btn-primary">
                                <i class="fa fa-image"></i>
                            </a>
                        </span>
                        </td>
                        <td>{{ $order->count }}</td>
                        <td>{{ $order->size }}</td>
                        <td>
                        <span data-toggle="tooltip" title="Engedélyezés">
                            <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#approve_{{ $order->id }}">
                                <i class="fa fa-check"></i>
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
        <div class="modal fade" id="approve_{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">Rendelés elfogadása</h4>
                    </div>
                    <div class="modal-body">
                        Biztos elfogadod ezt a rendelést?<br>
                        <i>Ezáltal bekerül trello-ba a "Beérkező" listába!</i>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('orders.approve', ['order' => $order]) }}" class="btn btn-success">Igen!</a>
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Mégse</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
