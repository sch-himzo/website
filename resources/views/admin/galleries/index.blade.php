@extends('layouts.main')

@section('title','Admin - Galériák')

@section('content')
    <h1 class="page-header with-description">Galériák &raquo;
        <a class="btn btn-lg btn-default" href="#" data-toggle="modal" data-target="#new_gallery"><i class="fa fa-plus"></i> Új galéria</a>
    </h1>
    <h2 class="page-description"><a href="{{ route('admin.index') }}">Vissza</a></h2>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Galériák</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <th style="text-align:center;">Leírás</th>
                            <th style="text-align:center;">Megtekintési jogosultság</th>
                            <th style="text-align:right;">Albumok</th>
                            <th align="right"></th>
                        </tr>
                        @foreach($galleries as $gallery)
                            <tr>
                                <td><a href="{{ route('admin.galleries.gallery', ['gallery' => $gallery]) }}">{{$gallery->name}}</a></td>
                                <td align="center">{{$gallery->description}}</td>
                                <td align="center">{{$gallery->role->name}}</td>
                                <td align="right">{{$gallery->albums->count()}}</td>
                                <td align="right" style="width: 10%">
                                    <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete_{{ $gallery->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="new_gallery">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('settings.galleries.new') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">Új galéria létrehozása</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="name">Név<span class="required">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Név" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="description">Leírás<span class="required">*</span></label>
                                <input type="text" name="description" id="description" class="form-control" placeholder="Leírás" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Megtekintéshez szükséges rank a weboldalon">
                                <label class="input-group-addon" for="role">Minimum rank</label>
                                <select class="form-control" required name="role" id="role">
                                    <option disabled selected>Válassz egyet!</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Mentés">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($galleries as $gallery)
        <div class="modal fade" id="delete_{{ $gallery->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Galéria törlése</h3>
                    </div>
                    <div class="modal-body">
                        <p>Biztosan törlöd ezt a galériát?</p>
                        <p><i>Az összes album és kép el fog veszni!</i></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Mégse</button>
                        <a href="{{ route('admin.galleries.delete', ['gallery' => $gallery]) }}" class="btn btn-danger">Törlés</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
