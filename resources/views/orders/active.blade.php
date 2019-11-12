@extends('layouts.main')

@section('orders.active.active','active')

@section('title','Aktív rendelések')

@section('content')
    <h1 class="page-header">Aktív rendelések</h1>
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Név</th>
                    <th>Határidő</th>
                    <th>Állapot</th>
                    <th>Megrendelő</th>
                    <th>Kép</th>
                    <th>Darabszám</th>
                </tr>
                @foreach($cards as $card)
                    <tr>
                        <td>{{ $card->order->first()->title }}</td>
                        <td>{{ $card->order->first()->time_limit }}</td>
                        <td>{{ $card->trelloList->name }}</td>
                        <td>@if($card->order->first()->user!=null) {{ $card->order->first()->user->name }} @elseif($card->order->first()->tempUser!=null) {{ $card->order->first()->tempUser->name }} @endif</td>
                        <td>{{ route('orders.getImage', ['order' => $card->order->first()]) }}</td>
                        <td>{{ $card->order->first()->count }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
