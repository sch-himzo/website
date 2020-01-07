@extends('layouts.main')

@section('title','Egyéb beállítások')

@section('content')
    <h1 class="page-header with-description">Egyéb beállítások</h1>
    <h2 class="page-description">
        <a href="{{ route('admin.index') }}">Vissza</a>
    </h2>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Főoldali galéria</h3>
                </div>
                <form action="{{ route('admin.misc.set_public_gallery') }}" method="POST">
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
                <form action="{{ route('admin.misc.set_orders_gallery') }}" method="POST">
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
                <form action="{{ route('admin.misc.set_orders_folder') }}" method="POST">
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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Hímzőgép státusz megtekintési jog</h3>
                </div>
                <form action="{{ route('admin.misc.set_machine_role') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="machine-role">Megtekintheti</label>
                                <select class="form-control" id="machine-role" name="machine_role">
                                    <option selected disabled>Válassz egyet!</option>
                                    @foreach(\App\Models\Role::all() as $role)
                                        @if($role->id>1)
                                            <option @if($role->id==$current_machine->viewable_by) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label class="input-group-addon" for="machine-role"><i class="fa fa-less-than-equal"></i></label>
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
