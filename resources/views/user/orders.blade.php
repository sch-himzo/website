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
                            <th>Kép</th>
                            <th>Darabszám</th>
                            <th>Állapot</th>
                            <th>Képek</th>
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
                                        <a target="_blank" href="{{ route('orders.getImage', ['order' => $order]) }}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    </span>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
