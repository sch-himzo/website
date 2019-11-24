@extends('layouts.main')

@section('title','Rendelés - '.$order->title)

@section('orders.active.active','active')

@section('content')
    <h1 class="page-header with-description">{{ $order->title }} &raquo; <a href="javascript:history.back();">Vissza</a></h1>
    <h2 class="page-description">Rendelés megtekintése</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="panel @if($order->status=="finished") panel-success @else panel-default @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">Rendelés információk</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Megrendelő</th>
                            <td>
                                @if($order->user)
                                     {{ $order->user->name }} (<i data-toggle="tooltip" title="Regisztrált felhasználó" class="fa fa-check"></i>)
                                @elseif($order->tempUser)
                                     {{ $order->tempUser->name }} (<i data-toggle="tooltip" title="Nem létező felhasználó" class="fa fa-exclamation-circle"></i>)
                                @else
                                    <i>N/A</i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Leadás időpontja</th>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        @if($dst!=null && $dst->svg!=null && $order->image!=null)
                            <tr>
                                <th>Küldött kép</th>
                                <td>
                                    <a data-toggle="tooltip" title="Kép megtekintése" href="{{ route('orders.getImage', ['order' => $order]) }}" class="btn btn-xs btn-primary">
                                        <i class="fa fa-image"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>Darabszám</th>
                            <td>
                                @if($order->count)
                                    {{ $order->count }} db
                                @else
                                    <i>N/A</i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Határidő</th>
                            <td>
                                @if($order->time_limit)
                                    {{ $order->time_limit }}
                                @else
                                    <i>Nincs</i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Típus</th>
                            <td>
                                {{ $order_types[$order->type] }}
                            </td>
                        </tr>
                        <tr>
                            <th>Belsős</th>
                            <td>
                                @if($order->internal)
                                    Igen <i class="fa fa-check"></i>
                                @else
                                    Nem <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Méret (<i class="fa fa-question" data-toggle="tooltip" title="Legnagyobb átmérő"></i>)
                            </th>
                            <td>
                                {{ $order->size }} cm
                            </td>
                        </tr>
                        <tr>
                            @if($order->getDST()!=null)
                                <th>
                                    Végleges méret (<i class="fa fa-question" data-toggle="tooltip" title="A folt területe visszaosztva átmérőre (mintha kör lenne)"></i>)
                                </th>
                                <td>
                                    {{ number_format($order->getDST()->size,2,',','.') }} cm
                                </td>
                            @endif
                        </tr>
                        @if($order->getCost()!=null)
                            <tr>
                                <th>Darabár</th>
                                <td>{{ number_format($order->getCost(),0,',','.') }} Ft</td>
                            </tr>
                            <tr>
                                <th>Szumma</th>
                                <td>{{ number_format($order->count*$order->getCost(),0,',','.') }} Ft</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit">
                        <i class="fa fa-edit"></i> Szerkesztés
                    </button>
                    @if(Auth::user()->role_id>2 && $order->status=='finished' && !$order->archived)
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#archive">
                        <i class="fa fa-archive"></i> Archiválás
                    </button>
                    @endif
                    @if(Auth::user()->role_id>4)
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete">
                            <i class="fa fa-trash"></i> Törlés
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel @if($dst!=null && $dst->svg!=null) panel-success @else panel-default @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        @if($dst!=null && $dst->svg!=null)
                            Kész rendelés
                        @else
                            Küldött fájlok
                        @endif
                    </h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <td align="center">
                                @if(!$order->image=="")
                                <img class="album-edit-image" src="{{ route('orders.getImage', ['order' => $order]) }}" alt="{{ $order->title }}">
                                @elseif($dst!=null && $dst->svg!=null)
                                    <img class="album-edit-image" src="{{ asset('storage/images/svg/'.$dst->svg)  }}">
                                @else
                                    <p align="center"><i>Nincs feltöltött kép</i></p>
                                @endif
                            </td>
                        </tr>
                        @if($dst==null || $dst->svg==null)
                        <tr>
                            <td>
                                @if($order->font)
                                    <a href="{{ route('orders.getFont', ['order' => $order]) }}"><i class="fa fa-file"></i> Font letöltése</a>
                                @else
                                    <p align="center"><i>Nincs feltöltött font</i></p>
                                @endif
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel @if($order->status=="finished") panel-success @else panel-info @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">Rendelés állapota</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Állapot</th>
                            <td>{{ $order->getStatusInternal() }}</td>
                        </tr>
                        <tr>
                            <th>Publikus</th>
                            <td>
                                @if($order->public_albums)
                                    Igen <i class="fa fa-check"></i>
                                @else
                                    Nem <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                @if($order->status=='arrived')
                    <div class="panel-footer">
                        <a href="{{ route('orders.approve', ['order' => $order, 'internal' => 1]) }}" class="btn btn-success">
                            <i class="fa fa-check"></i> Belsős
                        </a>
                        <a href="{{ route('orders.approve', ['order' => $order, 'internal' => 0]) }}" class="btn btn-success">
                            <i class="fa fa-check"></i> Külsős
                        </a>
                        <button data-toggle="modal" data-target="#delete" type="button" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Törlés
                        </button>
                    </div>
                @endif
            </div>
            <div class="panel @if($order->design==null) {{ "panel-danger" }} @else {{ "panel-success" }} @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">Feltöltött tervfájlok</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @if($order->design==null)
                            <tr>
                                <td align="center">
                                    <i class="fa fa-angry"></i> Nincs feltöltött tervfájl
                                </td>
                            </tr>
                        @else
                            @foreach($order->design->designs as $design)
                                <tr>
                                    <td>
                                        <i class="fa fa-file"></i> {{ \Illuminate\Support\Str::limit($design->name,20) }}
                                    </td>
                                    <td align="right">
                                        @if($design->extension()=="dst")
                                            <a data-toggle="tooltip" title="Terv kirajzolása" href="{{ route('designs.parse', ['design' => $design, 'order' => $order]) }}" class="btn btn-xs btn-default">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endif
                                        <a class="btn btn-xs btn-default" data-toggle="tooltip" title="Letöltés" href="{{ route('designs.get', ['design' => $design]) }}">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <span data-toggle="tooltip" title="Új verzió feltöltése">
                                            <button data-toggle="modal" data-target="#new_file_{{ $design->id }}" class="btn btn-primary btn-xs" type="button">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                @if($order->design==null)
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_files">
                            <i class="fa fa-plus"></i> Új tervfájl
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#select_files">
                            <i class="fa fa-plus"></i> Létező tervfájl
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel @if($dst!=null && $dst->colors->count()!=0) {{ "panel-success" }} @else {{ "panel-danger" }} @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">Színek</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @if($dst!=null)
                            @if($dst->colors->count()==0)
                                <tr>
                                    <td align="center">
                                        <i class="fa fa-angry"></i> Nem adtál meg színeket
                                    </td>
                                </tr>
                            @else
                                @foreach($dst->colors as $color)
                                    <tr>
                                        <td>{{ $color->number }}.</td>
                                        <td>
                                            @if($color->isacord)
                                                Isacord
                                            @else
                                                Sulky
                                            @endif
                                        </td>
                                        <td>{{ $color->code }}</td>
                                        <td style="background:rgb({{ $color->red }}, {{ $color->green }}, {{ $color->blue }});">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td>{{ number_format($color->stitch_count,0) }} öltés</td>
                                    </tr>
                                @endforeach
                            @endif
                            @if($dst->background != null)
                                <tr>
                                    <td>Háttérszín</td>
                                    <td colspan="2">{{ $dst->background->name }}</td>
                                    <td style="background:rgb({{ $dst->background->red }}, {{ $dst->background->green }}, {{ $dst->background->blue }} );">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" align="center">
                                        <i class="fa fa-angry"></i> Nem adtál meg háttérszínt
                                    </td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td align="center">
                                    <i class="fa fa-angry"></i> Nem töltöttél fel DST-t
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                @if($dst!=null && $dst->colors->count()==0)
                    <div class="panel-footer">
                        <a href="{{ route('designs.parse', ['design' => $dst, 'order' => $order]) }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Színek hozzáadása
                        </a>
                    </div>
                @elseif($dst!=null && $dst->colors->count()!=0)
                    <div class="panel-footer">
                        <a href="{{ route('designs.parse', ['design' => $dst, 'order' => $order]) }}" class="btn btn-warning">
                            <i class="fa fa-edit"></i> Színek szerkesztése
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
        @if($order->joint || Auth::user()->assignedOrders->find($order->id)!=null)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Hozzárendelt körtagok</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @if($order->assignedUsers->count()==0)
                            <tr>
                                <td align="center"><i>Nincs hozzárendelve senki</i></td>
                            </tr>
                        @else
                            @foreach($order->assignedUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                </tr>

                            @endforeach
                        @endif
                    </table>
                </div>
                <div class="panel-footer">
                    @if($order->assignedUsers->find(Auth::user()->id)!=null)
                        <a href="{{ route('orders.assign', ['order' => $order]) }}" class="btn btn-danger">
                            <i class="fa fa-minus"></i> Kilépek
                        </a>
                    @else
                        <a href="{{ route('orders.assign', ['order' => $order]) }}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Hozzárendelés
                        </a>
                    @endif
                </div>
            </div>
        @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kommentek</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @foreach($order->comments as $comment)
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
                    <form class="form-inline" action="{{ route('orders.comment', ['order' => $order]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment" id="comment" placeholder="Komment">
                        </div>
                        <input type="submit" value="Küldés" class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @if($order->design == null)
        <div class="modal fade" id="add_files">
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
        <div class="modal fade" id="select_files">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Létező tervfájlok csatolása</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        @foreach($design_groups as $design)
                            <div class="col-md-6">
                                <a class="modal-big-link" href="{{ route('designs.attach', ['design' => $design, 'order' => $order]) }}">
                                    {{ $design->name }}<br>
                                    @foreach($design->designs as $file)
                                    <p style="font-size:12px;">
                                        <i class="fa fa-file"></i> {{ $file->name }}
                                    </p>
                                    @endforeach
                                </a>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($order->approved_by==null || Auth::user()->role_id>4)
        <div class="modal fade" id="delete">
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
    @endif
    @if(Auth::user()->role_id>2 && $order->status=="finished" && !$order->archived)
        <div class="modal fade" id="archive">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Rendelés archiválása</h4>
                    </div>
                    <div class="modal-body">
                        Biztosan archiválod ezt a rendelést?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times"></i> Mégse
                        </button>
                        <a href="{{ route('orders.archive', ['order' => $order]) }}" class="btn btn-primary">
                            <i class="fa fa-archive"></i> Igen
                        </a>

                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Rendelés szerkesztése</h4>
                </div>
                <form action="{{ route('orders.edit', ['order' => $order]) }}" method="POST">
                    {{ csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="count">Darabszám<span class="required">*</span></label>
                                <input required type="number" min="0" class="form-control" name="count" id="count" placeholder="Darabszám" value="{{ $order->count }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="size">Méret<span class="required">*</span></label>
                                <input required type="number" min="0" class="form-control" name="size" id="size" placeholder="Méret" value="{{ $order->size }}">
                                <label class="input-group-addon">cm</label>
                            </div>
                        </div>
                        @if(($dst!=null && $dst->background!=null && $dst->colors->count()!=0 && $order->assignedUsers->contains(Auth::user())) || Auth::user()->role_id>4)
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="status">Státusz</label>
                                <select id="status" class="form-control" required name="status">
                                    <option selected disabled>Válassz egyet!</option>
                                        <option @if($order->status=="designed") selected @endif value="designed">Tervezve</option>
                                        <option @if($order->status=="embroidered") selected @endif value="embroidered">Hímezve</option>
                                        <option @if($order->status=="payed") selected @endif value="payed">Fizetve</option>
                                        <option @if($order->status=="finished") selected @endif value="finished">Kész</option>
                                </select>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                        <input type="submit" class="btn btn-primary" value="Mentés">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($order->design!=null)
        @foreach($order->design->designs as $design)
            <div class="modal fade" id="new_file_{{ $design->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('designs.orders.update', ['order' => $order, 'design' => $design]) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <button class="close" type="button" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Új verzió feltöltése</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label class="input-group-addon" for="file_{{ $design->id }}">@if($design->extension()=="art80" || $design->extension()=="art60") ART @elseif($design->extension()=="dst") DST @endif</label>
                                        <input accept="@if($design->extension()=="art80" || $design->extension()=="art60") .art80,.art60,.ART80,.ART60 @elseif($design->extension()=="dst") .DST,.dst @endif" type="file" name="file_{{ $design->id }}" id="file_{{ $design->id }}" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                                <button type="submit" class="btn btn-primary">Mentés</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
