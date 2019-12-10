@extends('layouts.main')

@section('title','Rendelés - '.$group->title)

@section('members.active','active')

@section('content')
    @if($group->archived)
        <div class="row">
            <div class="col-md-4 col-md-push-4">
                <div class="alert alert-info alert-dismissable">
                    <button class="close" data-dismiss="alert" type="button">&times</button>
                    <h4><i class="fa fa-exclamation-circle"></i> Archív rendelés</h4>
                    <p>Ez a rendelés archiválva van! Módosításrokról nem kap emailt a felhasználó.</p>
                </div>
            </div>
        </div>
    @endif
    <h1 class="page-header with-description">{{ $group->title }} &raquo; <a href="{{ route(session('return_to')) }}">Vissza</a></h1>
    <h2 class="page-description">Rendelés megtekintése</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="panel @if($group->status=="5") panel-success @else panel-default @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">Rendelés információk</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Megrendelő</th>
                            <td colspan="2">
                                @if($group->user)
                                     {{ $group->user->name }} (<i data-toggle="tooltip" title="Regisztrált felhasználó" class="fa fa-check"></i>)
                                @elseif($group->tempUser)
                                     {{ $group->tempUser->name }} (<i data-toggle="tooltip" title="Nem létező felhasználó" class="fa fa-exclamation-circle"></i>)
                                @else
                                    <i>N/A</i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Leadás időpontja</th>
                            <td colspan="2">{{ $group->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Határidő</th>
                            <td colspan="2">
                                @if($group->time_limit)
                                    {{ $group->time_limit }}
                                @else
                                    <i>Nincs</i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Belsős</th>
                            <td colspan="2">
                                @if($group->internal)
                                    Igen <i class="fa fa-check"></i>
                                @else
                                    Nem <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Állapot</th>
                            <td colspan="2">
                                @if(!$group->archived)
                                    {{ $group->getStatusInternal() }}
                                @else
                                    {{ 'Archivált' }}
                                @endif
                            </td>
                        </tr>
                        @if($group->eta!=null)
                            <tr>
                                <th>Várható elkészülés</th>
                                <td>{{ \Carbon\Carbon::create($group->eta)->diffForHumans() }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#change_status">
                        <i class="fa fa-edit"></i> Státusz szerkesztése
                    </button>
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#change_eta">
                        <i class="fa fa-calendar"></i> ETA megadása
                    </button>
                    @if(!$group->help)
                        <a href="{{ route('orders.help', ['order' => $group]) }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-exclamation"></i> HELP!
                        </a>
                    @else
                        <a href="{{ route('orders.help', ['order' => $group]) }}" class="btn btn-success btn-xs">
                            <i class="fa fa-check"></i> Megvagyok
                        </a>
                    @endif
                    @if($group->status>3 && ($group->assignedUsers->contains(Auth::id()) || Auth::user()->role_id>4))
                        @if(!$group->archived)
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#archive">
                                <i class="fa fa-archive"></i> Archiválás
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Minták</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Megnevezés</th>
                            <th>Állapot</th>
                            <th>Tervezést igényel</th>
                            <th>DST feltöltve</th>
                            <th>Színek kitöltve</th>
                        </tr>
                        @foreach($group->orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('orders.order', ['group' => $group, 'order' => $order]) }}">{{ $order->title }}</a>
                                </td>
                                <td>{{ $order->getStatusInternal() }}</td>
                                <td style="text-align:center;">
                                    @if($order->existing_design || $order->getDST()!=null)
                                        <i class="fa fa-times" data-toggle="tooltip" title="Van hozzá csatolt DST, vagy a megrendelő bepipálta, hogy létező design"></i>
                                    @else
                                        <i data-toggle="tooltip" title="Nincs hozzá csatolt DST, vagy a felhasználó új mintaként rendelte" class="fa fa-check"></i>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($order->getDST()==null)
                                        <i class="fa fa-times"></i>
                                    @else
                                        <i class="fa fa-check"></i>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($order->getDST()!=null && $order->getDST()->colors->count()!=0)
                                        <i class="fa fa-check"></i>
                                    @else
                                        <i class="fa fa-times"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Hozzárendelt körtagok</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @if($group->assignedUsers->count()==0)
                            <tr>
                                <td align="center"><i>Nincs hozzárendelve senki</i></td>
                            </tr>
                        @else
                            @foreach($group->assignedUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                </tr>

                            @endforeach
                        @endif
                    </table>
                </div>
                <div class="panel-footer">
                    @if($group->assignedUsers->find(Auth::user()->id)!=null)
                        <a href="{{ route('orders.assign', ['group' => $group]) }}" class="btn btn-xs btn-danger">
                            <i class="fa fa-minus"></i> Kilépek
                        </a>
                    @else
                        <a href="{{ route('orders.assign', ['group' => $group]) }}" class="btn btn-xs btn-success">
                            <i class="fa fa-plus"></i> Hozzárendelés
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kommentek</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @foreach($group->comments as $comment)
                            <tr>
                                <td>
                                    <b>{{ $comment->user->name }}</b><br>
                                    <i>{{ $comment->created_at->diffForHumans() }}</i>
                                </td>
                                <td>{{ $comment->comment }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="panel-footer">
                    <form class="form-inline" action="{{ route('orders.comment', ['group' => $group]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment" id="comment" placeholder="Komment">
                        </div>
                        <input type="submit" value="Küldés" class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
        @if($group->status>1)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fizetési információk</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            @foreach($group->orders as $order)
                                <?php $rowspan = 4; ?>
                                @if($order->getDesignCost()!=0)
                                    <?php $rowspan++; ?>
                                @endif
                                @if($order->getJumperCost()!=0)
                                    <?php $rowspan++; ?>
                                @endif
                                @if($order->getDesignCost()!=0)
                                    <tr>
                                        <th rowspan="<?= $rowspan ?>">{{ $order->title }}</th>
                                        <th>Tervezési költség</th>
                                        <td>{{ number_format($order->getDesignCost(),0,',','.') }} Ft</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Alapár</th>
                                    <td>{{ number_format($order->getBasePrice(),0,',','.') }} Ft</td>
                                </tr>
                                <tr>
                                    <th>Öltések ára</th>
                                    <td>{{ number_format($order->getEmbroideryCost(),0,',','.') }} Ft</td>
                                </tr>
                                @if($order->getJumperCost()!=0)
                                    <tr>
                                        <th>Hozott anyag</th>
                                        <td>{{ number_format($order->getJumperCost(),0,',','.') }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Darabár</th>
                                    <td>{{ number_format($order->getCost(),0,',','.') }} Ft</td>
                                </tr>
                                <tr>
                                    <th>Szumma</th>
                                    <td>{{ number_format($order->getTotalCost(),0,',','.') }} Ft</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th style="text-align:right;" colspan="2">Szumma</th>
                                <td>{{ number_format($group->getTotalCost(),0,',','.') }} Ft</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="change_status">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Állapot szerkesztése</h4>
                </div>
                <form action="{{ route('orders.changeStatus', ['group' => $group]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="status">Állapot</label>
                                <select class="form-control" name="status" id="status">
                                    <option disabled selected>Válassz egyet!</option>
                                    @foreach($statuses as $key => $status)
                                        <option value="{{ $key }}" @if($group->status==$key) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse <i class="fa fa-times"></i></button>
                        <button type="submit" class="btn btn-primary">Mentés <i class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_eta">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ETA Megadása</h4>
                </div>
                <form action="{{ route('orders.changeETA', ['group' => $group]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="eta">ETA</label>
                                <input @if($group->eta) value="{{ $group->eta }}" @endif type="date" id="eta" name="eta" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse <i class="fa fa-times"></i></button>
                        <button type="submit" class="btn btn-primary">Mentés <i class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($group->status>3 && ($group->assignedUsers->contains(Auth::id()) || Auth::user()->role_id>4))
        @if(!$group->archived)
            <div class="modal fade" id="archive">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Archiválás</h4>
                        </div>
                        <div class="modal-body">
                            <p>Biztosan archiválod ezt a rendelést?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Mégse <i class="fa fa-times"></i></button>
                            <a href="{{ route('orders.archive', ['order' => $group]) }}" class="btn btn-primary">Archiválás <i class="fa fa-archive"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
