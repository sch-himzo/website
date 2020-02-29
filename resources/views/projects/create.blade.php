@extends('layouts.main')

@section('title','Projekt létrehozása')

@section('content')
    <h1 class="page-header with-description">Új projekt</h1>
    <h2 class="page-description">
        <a href="#" onclick="window.history.back()">Vissza</a>
    </h2>
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            @switch($step)
                @case(2)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">{{ $name }}</h2>
                        </div>
                        <form action="{{ route('projects.create', ['step' => 3]) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="input-group" data-toggle="tooltip" title="Írd le miről szól a projekted!">
                                        <label class="input-group-addon" for="description">Leírás</label>
                                        <textarea rows="5" class="input-lg form-control" id="description" name="description" required>{{ $description }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('projects.create') }}" class="btn btn-lg btn-block btn-default">
                                            <i class="fa fa-angle-left"></i> Vissza
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary">
                                            Következő <i class="fa fa-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @break
                @case(3)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $name }}</h3>
                        </div>
                        <form action="{{ route('projects.save') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="input-group" data-toggle="tooltip" title="Töltsd fel a projektekhez tartozó fájlokat!">
                                        <label class="input-group-addon" for="files">Fájlok</label>
                                        <input type="file" multiple name="files[]" id="files" class="input-lg form-control" accept=".dst,.art80,image/*,.DST,.ART80,.art60,.ART60">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('projects.create', ['step' => 2]) }}" class="btn btn-lg btn-block btn-default">
                                            <i class="fa fa-angle-left"></i> Vissza
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary">
                                            Mentés <i class="fa fa-save"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @break
                @default
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Új projekt feltöltése</h3>
                    </div>
                    <form action="{{ route('projects.create', ['step' => 2]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="input-group" data-toggle="tooltip" title="Adj neved a projektednek!">
                                    <label class="input-group-addon" for="name">Név</label>
                                    <input type="text" class="input-lg form-control" id="name" name="name" placeholder="Projekt neve" required value="{{ $name }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-block btn-lg btn-primary">Következő <i class="fa fa-angle-right"></i></button>
                        </div>
                    </form>
                </div>
                @break
            @endswitch
        </div>
    </div>
@endsection
