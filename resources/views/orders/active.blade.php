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
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('orders.view', ['order' => $order]) }}">
                                {{ $order->title }}
                            </a>
                        </td>
                        <td>{{ $order->time_limit }}</td>
                        <td>{{ $order->getStatusInternal() }}</td>
                        <td>@if($order->user!=null) {{ $order->user->name }} @elseif($order->tempUser!=null) {{ $order->tempUser->name }} @endif</td>
                        <td>
                            @if($order->image!="")
                            <span data-toggle="tooltip" title="Kép megtekintése">
                                <a target="_blank" href="{{ route('orders.getImage', ['order' => $order]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-image"></i>
                                </a>
                            </span>
                            @endif
                        </td>
                        <td>{{ $order->count }}</td>
                        <td>
                            <a data-toggle="tooltip" title="Megtekintés" href="{{ route('orders.view', ['order' => $order]) }}" class="btn btn-xs btn-default">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if($order->user==null && $order->tempUser==null)
                                <span data-toggle="tooltip" title="Megrendelő hozzáadása">
                                    <button class="btn btn-success btn-xs" type="button" data-toggle="modal" data-target="#user_{{ $order->id }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </span>
                            @else
                                <span data-toggle="tooltip" title="Email küldése">
                                <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#email_{{ $order->id }}">
                                    <i class="fa fa-envelope"></i>
                                </button>
                            </span>
                            @endif
                            @if(in_array($order->status,['payed','embroidered','designed','finished']))
                                <span data-toggle="tooltip" title="Képek hozzáadása">
                                    <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#pictures_{{ $order->id }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </span>
                            @endif
                            @if($order->albums->count()!=0)
                                <a data-toggle="tooltip" title="Albumok" href="{{ route('orders.albums', ['order' => $order]) }}" class="btn btn-xs btn-default">
                                    <i class="fa fa-image"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @foreach($orders as $order)
        @if($order->design == null)
            <div class="modal fade" id="files_{{ $order->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="Button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Tervfájlok hozzáadása</h4>
                        </div>
                        <form action="{{ route('designs.orders.add', ['order' => $order]) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label class="input-group-addon" for="art80_{{ $order->id }}">ART80<span class="required">*</span></label>
                                        <input accept=".art80,.art60,.ART80,.ART60" type="file" name="art80_{{ $order->id }}" id="art80_{{ $order->id }}" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <label class="input-group-addon" for="dst_{{ $order->id }}">DST<span class="required">*</span></label>
                                        <input accept=".dst,.DST" type="file" name="dst_{{ $order->id }}" id="dst_{{ $order->id }}" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                                <input type="submit" value="Mentés" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if(in_array($order->status,['payed','embroidered','designed','finished']))
            <div class="modal fade" id="pictures_{{ $order->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Képek hozzáadása</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            @foreach($order->albums as $album)
                                    <div class="col-md-6">

                                        <a  href="{{ route('albums.view', ['album' => $album]) }}">
                                            <img class="modal-album-cover btn-image" src="{{ route('images.get',['image' => $album->getCover()]) }}">
                                        </a>
                                    </div>
                            @endforeach
                                <div class="col-md-6">
                                    <a data-toggle="tooltip" title="Új album" href="{{ route('albums.new',['order' => $order]) }}" class="btn btn-block btn-lg btn-default">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($order->user==null && $order->tempUser==null)
        <div class="modal fade" id="user_{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('orders.setUser', ['order' => $order]) }}" method="POST">
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
        <div class="modal fade" id="email_{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('orders.email', ['order' => $order]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Email küldése</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email">Email cím</label>
                                    <input readonly type="text" class="form-control" name="email" id="email" value="@if($order->user!=null) {{ $order->user->email }} @elseif($order->tempUser!=null) {{ $order->tempUser->email }} @endif">
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
                                    <input readonly type="text" class="form-control" name="title" id="title" value="{{ $order->title }}">
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
