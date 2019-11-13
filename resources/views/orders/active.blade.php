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
                    <th>Műveletek</th>
                </tr>
                @foreach($cards as $card)
                    <tr>
                        <td>{{ $card->order->first()->title }}</td>
                        <td>{{ $card->order->first()->time_limit }}</td>
                        <td>{{ $card->trelloList->name }}</td>
                        <td>@if($card->order->first()->user!=null) {{ $card->order->first()->user->name }} @elseif($card->order->first()->tempUser!=null) {{ $card->order->first()->tempUser->name }} @endif</td>
                        <td>
                            <span data-toggle="tooltip" title="Kép megtekintése">
                                <a target="_blank" href="{{ route('orders.getImage', ['order' => $card->order->first()]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-image"></i>
                                </a>
                            </span>
                        </td>
                        <td>{{ $card->order->first()->count }}</td>
                        <td>
                            @if($card->order->first()->user==null && $card->order->first()->tempUser==null)
                                <span data-toggle="tooltip" title="Megrendelő hozzáadása">
                                    <button class="btn btn-success btn-xs" type="button" data-toggle="modal" data-target="#user_{{ $card->id }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </span>
                            @else
                                <span data-toggle="tooltip" title="Email küldése">
                                <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#email_{{ $card->id }}">
                                    <i class="fa fa-envelope"></i>
                                </button>
                            </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @foreach($cards as $card)
        @if($card->order->first()->user==null && $card->order->first()->tempUser==null)
        <div class="modal fade" id="user_{{ $card->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('orders.setUser', ['order' => $card->order->first()]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Felhasználóhoz társítás</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="name">Név</label>
                                    <input type="text" name="name" id="name" placeholder="Név" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email">Email</label>
                                    <input type="email" name="email" id="email" placeholder="Email cím" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Mentés">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Mégse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="modal fade" id="email_{{ $card->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('orders.email', ['order' => $card->order->first()]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Email küldése</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email">Email cím</label>
                                    <input readonly type="text" class="form-control" name="email" id="email" value="@if($card->order->first()->user!=null) {{ $card->order->first()->user->email }} @elseif($card->order->first()->tempUser!=null) {{ $card->order->first()->tempUser->email }} @endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="title">Rendelés</label>
                                    <input readonly type="text" class="form-control" name="title" id="title" value="{{ $card->order->first()->title }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="message">Üzenet</label>
                                    <textarea class="form-control" name="message" id="message" placeholder="">(Nem kell köszönni, csak írd ide a kérdésed)</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Küldés">
                            <button data-dismiss="modal" type="button" class="btn btn-default">Mégse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endsection
