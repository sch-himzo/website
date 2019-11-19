@extends('layouts.main')

@section('title','Tervfájlok - '.$order->title)

@section('content')
    <h1 class="page-header with-description">{{ $order->title }}</h1>
    <h2 class="page-description">Rendeléshez tartozó tervfájlok</h2>

    <div class="row">
        @foreach($group->designs as $design)
            @if($design->extension() == "dst")
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">DST Fájl</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td><i class="fa fa-file"></i></td>
                                <td><a href="{{ route('designs.get',['design' => $design]) }}">{{ $design->name }}</a></td>
                                <td align="right">{{ $design->updated_at }}</td>
                                <td>
                                    <span data-toggle="tooltip" title="Új verzió feltöltése">
                                        <button class="btn btn-xs btn-primary" type="button" data-toggle="modal" data-target="#edit_{{ $design->id }}">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </span>
                                </td>
                                @if($design->extension()=='dst')
                                <td>
                                    <a class="btn btn-xs btn-default" data-toggle="tooltip" title="Kirajzolás" href="{{ route('designs.parse' ,['design' => $design]) }}">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                </td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @elseif($design->extension() == "art60" || $design->extension() == "art80")
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">ART Fájl</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td><i class="fa fa-file"></i></td>
                                    <td><a href="{{ route('designs.get',['design' => $design]) }}">{{ $design->name }}</a></td>
                                    <td align="right">{{ $design->updated_at }}</td>
                                    <td>
                                        <span data-toggle="tooltip" title="Új verzió feltöltése">
                                            <button class="btn btn-xs btn-primary" type="button" data-toggle="modal" data-target="#edit_{{ $design->id }}">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection

@section('modals')
    @foreach($group->designs as $design)
        <div class="modal fade" id="edit_{{ $design->id }}">
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
@endsection
