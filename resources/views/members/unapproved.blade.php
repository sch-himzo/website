@extends('layouts.members')

@section('title','Elfogadásra váró rendelések')

@section('page-title')
    <h1 class="page-header">Elfogadásra váró rendelések</h1>
@endsection

@section('members.unapproved.active','active')
@section('members.active','active')

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
                    <th>Műveletek</th>
                </tr>
                @if($orders->count()==0)
                    <tr>
                        <td colspan="5" align="center">
                            <i class="fa fa-smile"></i> <i>Nincs elfogadatlan rendelés</i>
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
                            <td>
                                <span data-togle="tooltip" title="Elfogadás">
                                    <button class="btn btn-xs btn-success" type="button" data-toggle="modal" data-target="#approve_{{ $order->id }}">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </span>
                                <span data-toggle="tooltip" title="Törlés">
                                    <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#delete_{{ $order->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endif
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
                        <a href="{{ route('orders.approve', ['order' => $order, 'internal' => false]) }}" class="btn btn-success">Igen (Schönherzes)</a>
                        <a href="{{ route('orders.approve', ['order' => $order, 'internal' => true]) }}" class="btn btn-success">Igen (Külsős)</a>
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Mégse</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete_{{ $order->id }}">
            <form action="{{ route('orders.delete', ['order' => $order]) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">&times;</button>
                            <h4 class="modal-title">Rendelés törlése</h4>
                        </div>
                        <div class="modal-body">
                            Biztos törlöd ezt a rendelést?<br>
                            <i>Ezáltal mindenhonnan elveszik - csak akkor töröld, ha biztos vagy benne, hogy duplikált, vagy, hogy kamu</i><br>
                            <b>A megrendelő kap erről emailt</b>

                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="reason_{{ $order->id }}">Indoklás<span class="required">*</span></label>
                                    <input required class="form-control" type="text" name="reason_{{ $order->id }}" id="reason_{{ $order->id }}" placeholder="Indoklás">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-danger" value="Igen!">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Nem</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endforeach
@endsection
