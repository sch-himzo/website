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
                        @if($order->user == null)
                            <td>{{ $order->tempUser->name }}</td>
                        @else

                            <td>{{ $order->user->name }}</td>
                        @endif
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
                        <span data-toggle="tooltip" title="Törlés">
                            <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete_{{ $order->id }}">
                                <i class="fa fa-trash"></i>
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
                        <a href="{{ route('orders.approve', ['order' => $order, 'internal' => '1']) }}" class="btn btn-success">Igen (Schönherzes)</a>
                        <a href="{{ route('orders.approve', ['order' => $order, 'internal' => '0']) }}" class="btn btn-success">Igen (Külsős)</a>
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
                                    <label class="input-group-addon" for="reason">Indoklás<span class="required">*</span></label>
                                    <input required class="form-control" type="text" name="reason" id="reason" placeholder="Indoklás">
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
