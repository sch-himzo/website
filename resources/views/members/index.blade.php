@extends('layouts.members')

@section('members.active','active')

@section('members.index.active','active')

@section('title','Tag főoldal')

@section('page-title')
    <h1 class="page-header">Irányítópult</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Közelgő határidejű rendelések</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th>Határidő</th>
                            <th>Körtagok</th>
                        </tr>
                        @foreach($time_limit as $order)
                            @if($order->assigned_users_count!=0)
                                <?php $i = 0; ?>
                                @foreach($order->assignedUsers as $user)
                                    <?php $i++; ?>
                                    @if($i==1)
                                        <tr>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                <a href="{{ route('orders.view', ['group' => $order]) }}">{{ $order->title }}</a>
                                            </td>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                {{ \Carbon\Carbon::create($order->time_limit)->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.view', ['group' => $order]) }}">{{ $order->title }}</a>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::create($order->time_limit)->diffForHumans() }}
                                    </td>
                                    <td>
                                        <i>Nincs hozzárendelve senki</i>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Átadásra váró rendelések</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th>Megrendelő</th>
                            <th>Fizetendő</th>
                            <th>Műveletek</th>
                        </tr>
                        @foreach($ready as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('orders.view', ['group' => $order]) }}">{{ $order->title }}</a>
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
                                <td>{{ number_format($order->getTotalCost(),0,',','.') }}</td>
                                <td>
                                <span data-toggle="tooltip" title="Késznek jelölés">
                                    <button type="button" data-toggle="modal" data-target="#ready_{{ $order->id }}" class="btn btn-xs btn-success">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nemrég elkészült rendelések</h3>
                </div>
                <div class="table table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th>Elkészült</th>
                            <th>Körtagok</th>
                        </tr>
                        @foreach($recent as $order)
                            @if($order->assigned_users_count!=0)
                                <?php $i = 0; ?>
                                @foreach($order->assignedUsers as $user)
                                    <?php $i++; ?>
                                    @if($i==1)
                                        <tr>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                <a href="{{ route('orders.view', ['group' => $order]) }}">{{ $order->title }}</a>
                                            </td>
                                            <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                {{ $order->updated_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.view', ['group' => $order]) }}">{{ $order->title }}</a>
                                    </td>
                                    <td>
                                        {{ $order->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <i>N/A</i>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-spin fa-wheelchair"></i> Segítségre szoruló rendelések</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th>Megrendelő</th>
                            <th>Státusz</th>
                            <th>Körtagok</th>
                        </tr>
                        @if($help==null || $help->count()==0)
                            <tr>
                                <td align="center" colspan="4">
                                    <i>Nincs ilyen rendelés</i>
                                </td>
                            </tr>
                        @else
                            @foreach($help as $order)
                                @if($order->assigned_users_count!=0)
                                    <?php $i = 0; ?>
                                    @foreach($order->assignedUsers as $user)
                                        <?php $i++; ?>
                                        @if($i==1)
                                            <tr>
                                                <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                    <a href="{{ route('orders.view', ['group' => $order]) }}">{{ $order->title }}</a>
                                                </td>
                                                <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                    @if($order->user!=null)
                                                        {{ $order->user->name }} <i class="fa fa-check" data-toggle="tooltip" title="Regisztrált felhasználó"></i>
                                                    @elseif($order->tempUser!=null)
                                                        {{ $order->tempUser->name }} <i class="fa fa-exclamation-circle" data-toggle="tooltip" title="Nem létező felhasználó"></i>
                                                    @else
                                                        <i>N/A</i>
                                                    @endif
                                                </td>
                                                <td style="vertical-align:middle;" rowspan="{{ $order->assigned_users_count }}">
                                                    {{ $order->getStatusInternal() }}
                                                </td>
                                                <td>
                                                    {{ $user->name }}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <a href="{{ route('orders.view', ['group' => $order]) }}">{{ $order->title }}</a>
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
                                            {{ $order->getStatusInternal() }}
                                        </td>
                                        <td>
                                            <i>N/A</i>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @foreach($ready as $order)
        <div class="modal fade" id="ready_{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Késznek jelölés</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Figyelem!</h4>
                        <p>Csak akkor jelöld késznek, ha át lett adva a rendelés, és ki is lett fizetve!</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Mégse</button>
                        <a href="{{ route('orders.done', ['order' => $order]) }}" class="btn btn-primary"><i class="fa fa-check"></i> Késznek jelölés</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
