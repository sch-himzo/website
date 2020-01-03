@extends('layouts.main')

@section('title','Főoldali beállítások')

@section('content')
    <h1 class="page-header">Főoldali beállítások</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Főoldali galéria</h3>
                </div>
                <form action="{{ route('settings.galleries.set') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="gallery" class="input-group-addon">Galéria</label>
                                <select name="gallery" id="gallery" class="form-control">
                                    <option selected disabled>Válassz egyet!</option>
                                    @foreach($galleries as $gallery)
                                        <option @if($current_gallery->id == $gallery->id) selected @endif value="{{ $gallery->id }}">{{ $gallery->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-save"></i> Mentés
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Rendelések galériája</h3>
                </div>
                <form action="{{ route('settings.galleries.orders.set') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="gallery_orders" class="input-group-addon">Galéria</label>
                                <select name="gallery_orders" id="gallery_orders" class="form-control">
                                    <option selected disabled>Válassz egyet!</option>
                                    @foreach($all_galleries as $gallery)
                                        <option @if($current_orders_gallery == $gallery->id) selected @endif value="{{ $gallery->id }}">{{ $gallery->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-save"></i> Mentés
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Rendelések mappája</h3>
                </div>
                <form action="{{ route('settings.orders.group.set') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="folder_orders" class="input-group-addon">Mappa</label>
                                <select name="folder_orders" id="folder_orders" class="form-control">
                                    <option selected disabled>Válassz egyet!</option>
                                    @foreach($all_folders as $folder)
                                        <option @if($current_orders_folder == $folder->id) selected @endif value="{{ $folder->id }}">{{ $folder->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-save"></i> Mentés
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
