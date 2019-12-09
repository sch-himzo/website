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
                            <th>Státusz</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($orders->count() == 0)
                            <tr>
                                <td align="center" colspan="4"><i>Nincs rendelésed</i></td>
                            </tr>
                        @endif
                        @foreach($orders as $group)
                            <tr>
                                <td>{{ $group->title }}</td>
                                <td>{{ $group->created_at }}</td>
                                <td>@if($group->time_limit!=null) {{ $group->time_limit }} @else <i>nincs</i> @endif</td>
                                <td>{{ $group->getStatusClient() }}</td>
                                <td>
                                    <span data-toggle="tooltip" title="Megtekintés">
                                        <button class="btn btn-xs btn-default" type="button" data-toggle="modal" data-target="#group_{{ $group->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </span>
                                    <span data-toggle="tooltip" title="Minták">
                                        <button class="btn btn-xs btn-default" type="button" data-toggle="modal" data-target="#orders_{{ $group->id }}">
                                            <i class="fa fa-pen-alt"></i>
                                        </button>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection

@section('modals')
    @foreach($orders as $group)
        <div class="modal fade" id="orders_{{ $group->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ $group->title }} - Minták</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            @foreach($group->orders as $order)
                                @if($order->existing_design)
                                    <tr>
                                        <th colspan="2" style="text-align:center;">Létező minta</th>
                                    </tr>
                                    <tr>
                                        <th>Megnevezés</th>
                                        <td>{{ $order->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Darabszám</th>
                                        <td>{{ $order->count }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <th colspan="2" style="text-align:center;">Új minta</th>
                                    </tr>
                                    <tr>
                                        <th>Megnevezés</th>
                                        <td>{{ $order->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Darabszám</th>
                                        <td>{{ $order->count }}</td>
                                    </tr>
                                    <tr>
                                        <th>Méret</th>
                                        <td>{{ $order->size }} cm</td>
                                    </tr>
                                    <tr>
                                        <th>Képek</th>
                                        <td>
                                            <?php $i=0; ?>
                                            @foreach($order->images as $image)
                                                <a rel="lightbox[modal_{{ $order->id }}]" href="{{ asset($image->getImage()) }}">
                                                    <?php $i++; if($i==1){ ?>
                                                    <span class="btn btn-primary btn-xs" data-toggle="tooltip" title="Képek megtekintése" data-lightbox="{{ $order->id }}">
                                                    <i class="fa fa-image"></i>
                                                </span>
                                                    <?php } ?>
                                                    <lg/a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        @if($order->font!=null)
                                            <th>Betűtípus</th>
                                            <td>{{ $order->font }}</td>
                                    </tr>
                                    <tr>
                                        @endif
                                        <th>Elképzelés</th>
                                        <td>{{ $order->comment }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Bezárás</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
