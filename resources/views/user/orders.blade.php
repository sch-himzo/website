@extends('layouts.main')

@section('title', 'Rendeléseim')

@section('user.orders.active','active')

@section('content')
        <h1 class="page-header">Rendeléseim</h1>

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cím</th>
                            <th>Leadva</th>
                            <th>Határidő</th>
                            <th>Képek</th>
                            <th>Darabszám</th>
                            <th>Állapot</th>
                            <th>Képek</th>
                            <th>Ár</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($orders->count() == 0)
                            <tr>
                                <td align="center" colspan="7"><i>Nincs rendelésed</i></td>
                            </tr>
                        @endif
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->title }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>@if($order->time_limit!=null) {{ $order->time_limit }} @else <i>nincs</i> @endif</td>
                                <td>
                                    <span data-toggle="tooltip" title="Kép megtekintése">
                                        <a data-lightbox="roadtrip" href="{{ route('orders.getImage', ['order' => $order]) }}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    </span>
                                    @if($order->getDST()!=null)
                                        <span data-toggle="tooltip" title="Elkészült tervfájl megtekintése">
                                            <button type="button" data-toggle="modal" data-target="#svg_{{ $order->id }}" class="btn btn-xs btn-primary">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $order->count }}</td>
                                <td>{{ $order->getStatusClient() }}</td>
                                <td>
                                    @if($order->albums->count()!=0)
                                        <a class="btn btn-xs btn-primary" data-toggle="tooltip" title="Albumok" href="{{ route('orders.albums', ['order' => $order]) }}">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    @else
                                        <i>Nincs feltöltött kép</i>
                                    @endif
                                </td>
                                @if($order->getCost()!=null)
                                    <td>@if($order->original) {{ $order->getDesignCost() }} + @endif {{ $order->count }} &times; {{ $order->getCost() }} = {{ number_format($order->getTotalCost(),0,',','.') }} Ft</td>
                                @else
                                    <td><i>Nem készült még el</i></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection

@section('modals')
    @foreach($orders as $order)
        @if($order->getDST()!=null)
            <div class="modal fade" id="svg_{{ $order->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Tervrajz megtekintése</h4>
                        </div>
                        <div class="modal-body">
                            <img class="album-edit-image" src="{{ asset('storage/images/svg/'. $order->getDST()->svg) }}" alt="{{ $order->title }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Bezárás</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
