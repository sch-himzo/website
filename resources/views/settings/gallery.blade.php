@extends('layouts.main')

@section('title', 'Galéria beállítások')

@section('content')
    <h1 class="page-header">Galériák &raquo;
        <a class="btn btn-lg btn-default" href="#" data-toggle="modal" data-target="#new_gallery"><i class="fa fa-plus"></i> Új galéria</a>
    </h1>
    <div class="row">
        @foreach($galleries as $gallery)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $gallery->name }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
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
@endsection
