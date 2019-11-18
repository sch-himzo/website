@extends('layouts.main')

@section('orders.active.active','active')

@section('title','Aktív rendelések')

@section('content')
    <h1 class="page-header">Aktív rendelések &raquo; <a data-toggle="tooltip" title="~10 másodperc" class="btn btn-lg btn-default" href="{{ route('orders.update') }}"><i class="fa fa-refresh"></i> Frissítés</a></h1>
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
                        <td>{{ $card->order->title }}</td>
                        <td>{{ $card->order->time_limit }}</td>
                        <td>{{ $card->order->getStatusInternal() }}</td>
                        <td>@if($card->order->user!=null) {{ $card->order->user->name }} @elseif($card->order->tempUser!=null) {{ $card->order->tempUser->name }} @endif</td>
                        <td>
                            @if($card->order->image!="")
                            <span data-toggle="tooltip" title="Kép megtekintése">
                                <a target="_blank" href="{{ route('orders.getImage', ['order' => $card->order]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-image"></i>
                                </a>
                            </span>
                            @endif
                        </td>
                        <td>{{ $card->order->count }}</td>
                        <td>
                            @if($card->order->user==null && $card->order->tempUser==null)
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
                            @if(in_array($card->order->status,['payed','embroidered','designed','finished']))
                                <span data-toggle="tooltip" title="Képek">
                                    <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#pictures_{{ $card->id }}">
                                        <i class="fa fa-image"></i>
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
        @if(in_array($card->order->status,['payed','embroidered','designed','finished']))
            <div class="modal fade" id="pictures_{{ $card->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Képek hozzáadása</h4>
                        </div>
                        <div class="modal-body">
                            @foreach($card->order->albums as $album)
                                <div class="modal-album">
                                    <a href="{{ route('albums.view', ['album' => $album]) }}">
                                        <img class="modal-album-cover" src="{{ route('images.get',['image' => $album->getCover()]) }}">
                                    </a>
                                </div>
                            @endforeach
                            <div class="modal-album">
                                <a data-toggle="tooltip" title="Új album" href="{{ route('albums.new',['order' => $card->order]) }}" class="btn btn-block btn-lg btn-default">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($card->order->user==null && $card->order->tempUser==null)
        <div class="modal fade" id="user_{{ $card->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('orders.setUser', ['order' => $card->order]) }}" method="POST">
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
                    <form action="{{ route('orders.email', ['order' => $card->order]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Email küldése</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email">Email cím</label>
                                    <input readonly type="text" class="form-control" name="email" id="email" value="@if($card->order->user!=null) {{ $card->order->user->email }} @elseif($card->order->tempUser!=null) {{ $card->order->tempUser->email }} @endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="bcc">BCC</label>
                                    <input readonly type="text" class="form-control" name="bcc" id="bcc" value="{{ Auth::user()->email }}, himzo@sch.bme.hu">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="title">Rendelés</label>
                                    <input readonly type="text" class="form-control" name="title" id="title" value="{{ $card->order->title }}">
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
