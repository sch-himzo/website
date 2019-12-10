@extends('layouts.main')

@section('title','Rendelés - '.$order->title)

@section('content')
    <h1 class="page-header with-description">{{ $order->title }} &raquo; <a href="{{ route('orders.view', ['group' => $group]) }}">Vissza</a></h1>
    <h2 class="page-description">{{ $group->title }}</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Minta adatai</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Megnevegés</th>
                            <td>{{ $order->title }}</td>
                        </tr>
                        <tr>
                            <th>Darabszám</th>
                            <td>{{ $order->count }}</td>
                        </tr>
                        <tr>
                            <th>Típus</th>
                            <td>{{ $order_types[$order->type] }}</td>
                        </tr>
                        <tr>
                            <th>Állapot</th>
                            <td>{{ $statuses[$order->status] }}</td>
                        </tr>
                        @if($order->font)
                            <tr>
                                <td>Betűtípus</td>
                                <td><a class="btn btn-default" href="{{ route('orders.getFont', ['order' => $order]) }}">
                                        <i class="fa fa-download"></i>
                                    </a></td>
                            </tr>
                        @endif
                        @if($order->existing_design)
                        <tr>
                            <th style="text-align:center;" colspan="2">Létező minta</th>
                        </tr>
                            @if($order->design)
                                <tr>
                                    <th>Minta neve</th>
                                    <td>{{ $order->design->name }}</td>
                                </tr>
                                @if($dst)
                                    <tr>
                                        <th>Öltésszám</th>
                                        <td>{{ number_format($dst->stitch_count,0,',','.') }} öltés</td>
                                    </tr>
                                @endif
                            @endif
                        @else
                            <tr>
                                <th>Csatolt képek</th>
                                <td>
                                    <?php $i=0; ?>
                                    @foreach($order->images as $image)
                                        <a rel="lightbox[{{ $order->id }}]" href="{{ asset($image->getImage()) }}">
                                            <?php $i++; if($i==1){ ?>
                                            <span class="btn btn-primary btn-xs" data-toggle="tooltip" title="Képek megtekintése" data-lightbox="{{ $order->id }}">
                                                    <i class="fa fa-image"></i>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Méret</th>
                                <td>{{ $order->size }} cm</td>
                            </tr>
                            <tr>
                                <th>Elképzelés</th>
                                <td>{{ $order->comment }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="panel-footer">
                    @if($order->existing_design && $dst==null)
                        <button type="button" data-toggle="modal" data-target="#add_design" class="btn btn-primary btn-xs">
                            <i class="fa fa-paperclip"></i> Tervfájlok csatolása
                        </button>
                        <a href="{{ route('orders.existing', ['order' => $order]) }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-times"></i> Tervezést igényel
                        </a>
                    @elseif(!$order->existing_design && $dst==null)
                        <button type="button" data-toggle="modal" data-target="#upload_design" class="btn btn-primary btn-xs">
                            <i class="fa fa-plus"></i> Tervfájlok feltöltése
                        </button>
                        <a href="{{ route('orders.existing', ['order' => $order]) }}" class="btn btn-success btn-xs">
                            <i class="fa fa-check"></i> Nem igényel tervezést
                        </a>
                    @elseif($dst!=null)
                        <button type="button" data-toggle="modal" data-target="#add_design" class="btn btn-primary btn-xs">
                            <i class="fa fa-paperclip"></i> Másik tervfájl kiválasztása
                        </button>
                    @endif
                    @if($order->status>1)
                        <button type="button" data-toggle="modal" data-target="#edit_status" class="btn btn-default btn-xs">
                            <i class="fa fa-edit"></i> Állapot módosítása
                        </button>
                    @endif
                </div>
            </div>
            <div class="panel @if($dst!=null && $dst->colors->count()!=0) {{ "panel-success" }} @else {{ "panel-danger" }} @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">Színek</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @if($dst!=null)
                            @if($dst->colors==null)
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
                                        <td>{{ number_format($color->stitch_count,0,',','.') }} öltés</td>
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
                @if($dst!=null && $dst->colors==null)
                    <div class="panel-footer">
                        <a href="{{ route('designs.parse', ['design' => $dst, 'order' => $order]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-plus"></i> Színek hozzáadása
                        </a>
                    </div>
                @elseif($dst!=null && $dst->colors!=null)
                    <div class="panel-footer">
                        <a href="{{ route('designs.parse', ['design' => $dst, 'order' => $order]) }}" class="btn btn-xs btn-warning">
                            <i class="fa fa-edit"></i> Színek szerkesztése
                        </a>
                    </div>
                @endif
            </div>
            @if($order->design!=null)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tervfájlok</h3>
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
                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#add_files">
                                <i class="fa fa-plus"></i> Új tervfájl
                            </button>
                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#select_files">
                                <i class="fa fa-plus"></i> Létező tervfájl
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                @if($dst!=null)
                    <div class="panel-heading">
                        <h3 class="panel-title">DST</h3>
                    </div>
                    <div class="panel-body">
                        @if($dst->svg==null)
                            <p style="text-align:center;"><i>Nincs még kirajzolva </i><i class="fa fa-frown"></i></p>
                        @else
                            <img src="{{ asset('storage/images/svg/'.$dst->svg) }}">
                        @endif
                    </div>
                    <div class="panel-footer">
                        @if($dst->svg==null)
                            <a href="{{ route('designs.parse', ['design' => $dst, 'order' => $order]) }}" class="btn btn-primary btn-xs">
                                Kirajzolás <i class="fa fa-pen"></i>
                            </a>
                        @else
                            <a href="{{ route('designs.redraw', ['order' => $order]) }}" class="btn btn-primary btn-xs">
                                <i class="fa fa-pen"></i> SVG Újrarajzolása
                            </a>
                        @endif
                        @if($dst!=null)
                            <button id="refresh_button" type="button" data-toggle="modal" data-target="#change_design" class="btn btn-warning btn-xs">
                                <i id="fa" class="fa fa-refresh"></i> Új tervfájlok feltöltése
                            </button>
                        @endif
                    </div>
                @else
                    <div class="panel-heading">
                        <h3 class="panel-title">Feltöltött DST</h3>
                    </div>
                    <div class="panel-body">
                        <p style="text-align:center;"><i>Nincs DST csatolva ehhez a mintához</i> <i class="fa fa-frown"></i></p>
                    </div>
                @endif
            </div>
            @if($dst && $dst->colors->count()!=0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Próbahímzés</h3>
                    </div>
                    <div class="panel-body" style="text-align:center;">
                        @if($order->testAlbum==null)
                            <p style="text-align:center;"><i>Nem töltöttél fel próbahímzésről képet </i><i class="fa fa-frown"></i></p>
                        @else
                            <a href="{{ asset('storage/images/real/'.$order->testAlbum->images->first()->image) }}" data-lightbox="testImage">
                                <img class="album-edit-image" src="{{ asset('storage/images/real/'.$order->testAlbum->images->first()->image) }}" alt="{{ $order->testAlbum->images->first()->title }}">
                            </a>
                        @endif
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#add_test_image">
                            <i class="fa fa-plus"></i> Próbahímzés feltöltése
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('modals')
    @if($dst)
        <div class="modal fade" id="add_test_image">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Próbahímzés feltöltése</h4>
                    </div>
                    <form action="{{ route('orders.testImage', ['order' => $order]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="image">Kép</label>
                                    <input type="file" accept="image/*" name="image" id="image" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Mégse <i class="fa fa-times"></i></button>
                            <button type="submit" class="btn btn-primary">Mentés <i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if($dst!=null)
        <div class="modal fade" id="change_design">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="Button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Tervfájlok hozzáadása</h4>
                    </div>
                    <form action="{{ route('designs.orders.updateSingle', ['order' => $order]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="art80_{{ $order->id }}">ART80</label>
                                    <input accept=".art80,.art60,.ART80,.ART60" type="file" name="art80_{{ $order->id }}" id="art80_{{ $order->id }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="dst_{{ $order->id }}">DST</label>
                                    <input accept=".dst,.DST" type="file" name="dst_{{ $order->id }}" id="dst_{{ $order->id }}" class="form-control">
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
    <div class="modal fade" id="edit_status">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Állapot szerkesztése</h4>
                </div>
                <form action="{{ route('orders.editStatus', ['order' => $order]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="status">Állapot</label>
                                <select class="form-control" name="status" id="status">
                                    <option disabled selected>Válassz egyet</option>
                                    @foreach($statuses as $key => $status)
                                        <option value="{{ $key }}" @if($order->status==$key) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Mégse <i class="fa fa-times"></i></button>
                        <button type="submit" class="btn btn-primary">Mentés <i class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(($order->existing_design && $dst==null) || ($dst!=null))
        <input type="hidden" id="design_url" value="{{ route('designs.find') }}">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="order_id" value="{{ $order->id }}">
        <div class="modal fade" id="add_design">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Tervfájlok csatolása</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="design">Keresés</label>
                                <input type="text" class="form-control" name="design" id="design" placeholder="Tervfájl">
                            </div>
                        </div>
                        <div class="buttons" id="buttons"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!$order->existing_design && $dst==null)
        <div class="modal fade" id="upload_design">
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
@endsection

@section('scripts')
    @if($order->existing_design || $dst!=null)
        <script src="{{ asset('js/design.js') }}"></script>
    @endif
    <script>
        $('#refresh_button').on('mouseenter',function(){
            $('#fa').attr('class','fa fa-refresh fa-spin');
        });
        $('#refresh_button').on('mouseleave', function(){
            $('#fa').attr('class','fa fa-refresh');
        })
    </script>
@endsection
