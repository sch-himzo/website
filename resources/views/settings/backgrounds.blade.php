@extends('layouts.main')

@section('title','Kordurák')

@section('content')
    <h1 class="page-header">Kordurák &raquo; <button type="button" data-toggle="modal" data-target="#new" class="btn btn-lg btn-default"><i class="fa fa-plus"></i> Új hozzáadása</button></h1>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Éppen használt kordurák</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    @if($backgrounds->count()==0)
                        <tr>
                            <td align="center"><i>Nincs itt semmi</i> <i class="fa fa-frown-o"></i></td>
                        </tr>
                    @else
                        <tr>
                            <th>Név és kód</th>
                            <th style="text-align:center;">Szín</th>
                            <th style="text-align:right;">Műveletek</th>
                        </tr>
                    @endif
                    @foreach($backgrounds as $background)
                        <tr>
                            <td style="width:25%;">{{ $background->name }}</td>
                            <td style="width:50%; background:rgb({{ $background->red }}, {{ $background->green }}, {{ $background->blue }} );"></td>
                            <td align="right">
                                <span data-toggle="tooltip" title="Szerkesztés">
                                    <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit_{{ $background->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </span>
                                <span data-toggle="tooltip" title="Törlés">
                                    <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete_{{ $background->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="new">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Új kordura hozzáadása</h4>
                </div>
                <form action="{{ route('settings.backgrounds.new') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="name">Név és kód<span class="required">*</span></label>
                                <input type="text" class="form-control" placeholder="Név + kód" name="name" id="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="red">Piros<span class="required">*</span></label>
                                <input min="0" max="255" type="number" class="form-control" placeholder="Piros" name="red" id="red" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="green">Zöld<span class="required">*</span></label>
                                <input min="0" max="255" type="number" class="form-control" placeholder="Zöld" name="green" id="green" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="blue">Kék<span class="required">*</span></label>
                                <input min="0" max="255" type="number" class="form-control" placeholder="Kék" name="blue" id="blue" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                        <input type="submit" value="Mentés" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($backgrounds as $background)
        <div class="modal fade" id="edit_{{ $background->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Kordura szerkesztése</h4>
                    </div>
                    <form action="{{ route('settings.backgrounds.edit', ['background' => $background]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="name_{{ $background->id }}">Név és kód<span class="required">*</span></label>
                                    <input value="{{ $background->name }}" type="text" class="form-control" placeholder="Név + kód" name="name_{{ $background->id }}" id="name_{{ $background->id }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="red_{{ $background->id }}">Piros<span class="required">*</span></label>
                                    <input value="{{ $background->red }}" min="0" max="255" type="number" class="form-control" placeholder="Piros" name="red_{{ $background->id }}" id="red_{{ $background->id }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="green_{{ $background->id }}">Zöld<span class="required">*</span></label>
                                    <input value="{{ $background->green }}" min="0" max="255" type="number" class="form-control" placeholder="Zöld" name="green_{{ $background->id }}" id="green_{{ $background->id }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="blue_{{ $background->id }}">Kék<span class="required">*</span></label>
                                    <input value="{{ $background->blue }}" min="0" max="255" type="number" class="form-control" placeholder="Kék" name="blue_{{ $background->id }}" id="blue_{{ $background->id }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                            <input type="submit" value="Mentés" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete_{{ $background->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Kordura törlése</h3>
                    </div>
                    <div class="modal-body">
                        <p>Biztosan törlöd ezt a kordurát?</p>
                        <p><i>Az összes ilyen alapú tervnél elveszik, hogy ez a háttere</i></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Mégse</button>
                        <a href="{{ route('settings.backgrounds.delete', ['background' => $background]) }}" class="btn btn-danger">Törlés</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
