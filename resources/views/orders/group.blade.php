@extends('layouts.main')

@section('title','Rendelés - '.$group->title)

@section('members.active','active')

@section('content')
    @if($group->archived)
        <div class="row">
            <div class="col-md-4 col-md-push-4">
                <div class="alert alert-info alert-dismissable">
                    <button class="close" data-dismiss="alert" type="button">&times;</button>
                    <h4><i class="fa fa-exclamation-circle"></i> Archív rendelés</h4>
                    <p>Ez a rendelés archiválva van! Módosításrokról nem kap emailt a felhasználó.</p>
                </div>
            </div>
        </div>
    @endif
    @if($group->report_spam)
        <div class="row">
            <div class="col-md-4 col-md-push-4">
                <div class="alert alert-warning alert-dismissable">
                    <button class="close" data-dismiss="alert" type="button">&times;</button>
                    <h4><i class="fa fa-exclamation-circle"></i> SPAM-nek jelölt</h4>
                    <p>Ezt a rendelést <b>{{ $group->reporter->name }}</b> SPAM-nek jelölte, jelenleg moderálásra vár, ha tényleg spam törölve lesz.</p>
                    @if(Auth::user()->role_id>4)
                        <a href="{{ route('orders.groups.spam.delete', ['group' => $group]) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Törlés</a>
                        <a href="{{ route('orders.groups.spam.unset', ['group' => $group]) }}" class="btn btn-default"><i class="fa fa-check"></i> Nem SPAM</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <h1 class="page-header with-description">{{ $group->title }} &raquo; <a href="{{ route(session('return_to'), session('return_to_parameters')) }}">Vissza</a></h1>
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
                        @if($group->comment!=null)
                        <tr>
                            <th>Megjegyzés</th>
                            <td>{{ $group->comment }}</td>
                        </tr>
                        @endif
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
                    @if(Auth::user()->role_id>4)
                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit">
                            <i class="fa fa-edit"></i> Szerkesztés
                        </button>
                    @endif
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#change_eta">
                        <i class="fa fa-calendar"></i> ETA megadása
                    </button>
                    @if(!$group->help)
                        <a href="{{ route('orders.groups.help', ['group' => $group]) }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-exclamation"></i> HELP!
                        </a>
                    @else
                        <a href="{{ route('orders.groups.help', ['group' => $group]) }}" class="btn btn-success btn-xs">
                            <i class="fa fa-check"></i> Megvagyok
                        </a>
                    @endif
                    @if($group->status<=1 && !$group->report_spam)
                        <button type="button" data-toggle="modal" data-target="#mark_spam" class="btn btn-danger btn-xs">
                            <i class="fa fa-ban"></i> SPAM
                        </button>
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
                                    <a href="{{ route('orders.view', ['group' => $group, 'order' => $order]) }}">{{ $order->title }}</a>
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
                @if(!$group->archived && $group->status<4)
                    <div class="panel-footer">
                        <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#new_order">További minta <i class="fa fa-plus"></i></button>
                    </div>
                @endif
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
                        <a href="{{ route('orders.groups.assign', ['group' => $group]) }}" class="btn btn-xs btn-danger">
                            <i class="fa fa-minus"></i> Kilépek
                        </a>
                    @else
                        <a href="{{ route('orders.groups.assign', ['group' => $group]) }}" class="btn btn-xs btn-success">
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
                    <form class="form-inline" action="{{ route('orders.groups.comment', ['group' => $group]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment" id="comment2" placeholder="Komment">
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
    @if(Auth::user()->role_id>4)
        <div class="modal fade" id="edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Rendelés szerkesztése</h4>
                    </div>
                    <form action="{{ route('orders.groups.edit', ['group' => $group]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="edit_name" class="input-group-addon">Név</label>
                                    <input type="text" id="edit_name" name="edit_name" class="form-control" value="@if($group->user){{ $group->user->name }}@elseif($group->tempUser){{ $group->tempUser->name }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="edit_email" class="input-group-addon">Email</label>
                                    <input type="text" id="edit_email" name="edit_email" class="form-control" value="@if($group->user){{ $group->user->email }}@elseif($group->tempUser){{ $group->tempUser->email }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="edit_time_limit" class="input-group-addon">Határidő</label>
                                    <input type="date" id="edit_time_limit" name="edit_time_limit" class="form-control" value="{{ $group->time_limit }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="edit_comment" class="input-group-addon">Megjegyzés</label>
                                    <textarea id="edit_comment" name="edit_comment" class="form-control">{{ $group->comment }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-times"></i> Mégse
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Mentés
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if($group->status<4 && $group->archived!=true)
        <div class="modal fade" id="new_order">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">További minta hozzáadása</h4>
                    </div>
                    <form action="{{ route('orders.groups.add', ['group' => $group]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group" data-toggle="tooltip" title="Minta neve">
                                    <label for="title" class="input-group-addon">Cím<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" required placeholder="Cím">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="existing">
                                        <input type="checkbox" id="existing" name="existing">
                                        Már volt ilyen rendelve
                                    </label>
                                </div>
                                <div class="input-group" data-toggle="tooltip" title="Képenként Max. 3MB">
                                    <label id="image_label" class="input-group-addon" for="image">Tervrajzok<span class="required">*</span></label>
                                    <input accept="image/*" required class="form-control" type="file" id="image" name="image[]" multiple>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" data-toggle="tooltip" title="Hány darabot szeretnél rendelni?">
                                    <label class="input-group-addon" for="count">Darabszám<span class="required">*</span></label>
                                    <input required class="form-control" type="number" id="count" name="count" placeholder="Darabszám">
                                </div>
                            </div>
                            <div class="form-group" data-toggle="tooltip" title="Foltot rendelsz, vagy pólóra/pulcsira hímzendő mintát?">
                                <input type="hidden" name="type" value="badge" id="order_type">
                                <input class="badge-select btn btn-primary left" type="button" value="Folt" id="badge_button"><input class="badge-select btn btn-default center" type="button" value="Pólóra" id="shirt_button"><input class="badge-select btn btn-default right" type="button" value="Pulcsira" id="jumper_button">
                            </div>

                            <div class="form-group">
                                <div class="input-group" data-toggle="tooltip" title="A folt átmérője (cm-ben)">
                                    <label id="size_label" class="input-group-addon" for="size">Méret<span class="required">*</span></label>
                                    <input required class="form-control" type="text" name="size" id="size" placeholder="Méret">
                                    <span class="input-group-addon">cm</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" data-toggle="tooltip" title="Ha különleges betűtípust igényel a folt">
                                    <label id="font_label" class="input-group-addon" for="font">Betűtípus</label>
                                    <input accept=".ttf" class="form-control" type="file" name="font" id="font">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" data-toggle="tooltip" title="Szöveges leírás a folt elképzeléséről">
                                    <label id="comment_label" class="input-group-addon" for="comment">Elképzelés<span class="required">*</span></label>
                                    <textarea required name="comment" id="comment" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Mégse <i class="fa fa-times"></i></button>
                            <button type="submit" id="more" class="btn btn-primary">Mentés <i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="change_status">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Állapot szerkesztése</h4>
                </div>
                <form action="{{ route('orders.groups.status', ['group' => $group]) }}" method="POST">
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
                <form action="{{ route('orders.groups.ETA', ['group' => $group]) }}" method="POST">
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
    @if($group->status<2 && !$group->report_spam)
        <div class="modal fade" id="mark_spam">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">SPAM-nek jelölés</h4>
                    </div>
                    <div class="modal-body">
                        <p>Biztosan SPAM-nek jelölöd ezt a rendelést?</p>
                        <p><i>Ha spamnek jelölöd a körvezetőnek el kell fogadnia, hogy tényleg spam, és utána fog csak törlődni</i></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Mégse</button>
                        <a class="btn btn-primary" href="{{ route('orders.groups.spam', ['group' => $group]) }}"><i class="fa fa-ban"></i> Igen!</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
                            <a href="{{ route('orders.groups.archive', ['group' => $group]) }}" class="btn btn-primary">Archiválás <i class="fa fa-archive"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('js/order.js') }}"></script>
@endsection
