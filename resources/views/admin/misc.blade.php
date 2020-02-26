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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Minimum határidő a rendeléshez</h3>
                </div>
                <form action="{{ route('admin.misc.min_time') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="min_time" class="input-group-addon">Idő</label>
                                <select class="form-control" id="min_time" name="min_time">
                                    <option selected disabled>Válassz egyet!</option>
                                    <option value="{{ 24*60 }}" @if($current_min_time==24*60) selected @endif>1 nap</option>
                                    <option value="{{ 2*24*60 }}" @if($current_min_time==2*24*60) selected @endif>2 nap</option>
                                    <option value="{{ 3*24*60 }}" @if($current_min_time==3*24*60) selected @endif>3 nap</option>
                                    <option value="{{ 7*24*60 }}" @if($current_min_time==7*24*60) selected @endif>1 hét</option>
                                    <option value="{{ 14*24*60 }}" @if($current_min_time==14*24*60) selected @endif>2 hét</option>
                                    <option value="{{ 31*24*60 }}" @if($current_min_time==31*24*60) selected @endif>1 hónap</option>
                                </select>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input @if($current_min_date!=null) checked @endif type="checkbox" id="min_date_check">
                                Dátumhoz kötés
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="min_date">Dátum</label>
                                <input @if($current_min_date!=null) value="{{ date("Y-m-d",$current_min_date) }}" @else disabled @endif type="date"  id="min_date" class="form-control" name="min_date">
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

@section('scripts')
    <script>
        $('#min_date_check').on('keyup click change', function(){
            if($('#min_date_check').is(':checked')) {
                $('#min_date').removeAttr('disabled');
                $('#min_date').removeAttr('required');
            }else{
                $('#min_date').attr('disabled','disabled');
                $('#min_date').attr('required','required');
            }
        });
    </script>
@endsection
