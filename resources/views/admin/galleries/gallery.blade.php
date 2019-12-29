@extends('layouts.main')

@section('title','Admin')

@section('content')
    <h1 class="page-header with-description">{{ $gallery->name }} &raquo;
        <a class="btn btn-lg btn-default" href="#" data-toggle="modal" data-target="#new_album"><i class="fa fa-plus"></i> Új album</a>
    </h1>
    <h2 class="page-description">
        <a href="{{ route('admin.galleries.index') }}">Vissza</a>
    </h2>
    <div class="row">
        @foreach($albums as $album)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $album->name }}</h3>
                    </div>
                    <div class="table-responsive">
                        <a href="{{ route('admin.albums.album', ['album' => $album]) }}">
                            <table class="table">
                                <tr>
                                    <td align="center">
                                        @if ($album->images->count() == 0)
                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAANlBMVEXz9Pa5vsq2u8jN0dnV2N/o6u7FydPi5Onw8fS+ws3f4ee6v8v29/jY2+Hu7/Ly9PbJztbQ1dxJagBAAAAC60lEQVR4nO3b2ZaCMBREUQbDJOP//2wbEGVIFCHKTa+zH7uVRVmBBJQgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMCpdOzvQQqaq2KmuSrOzQ02lSeRem8rpsQq/ozg72Kj4UkAxEev8awnzs7P1yiIadsfpQXjfZCHhUCzbfmeurdNz6bDRsBWRsB+k0cXxdHjpa0wkTBn3hKnjzRZyEgYk3IeEv2RKWCt1cN9EJ0zjfm7Mq/rAVgUnbLpwnK/zA2tnuQmzJHquuqJq91blJuwmAW8rHbV3q2ITFrOAt7Xz3l2UmrBMlpcHe9fOUhOqRYVhFO/cqtSEy0H6bh/tJ1uhCctqlTB/NSnG9pOt1ISXjxLq825laVFowo9GaRPrF9talJqw3n6macaZ09yi1ISG2cLyriwePwxzi1ITru4s2naxma59TC2KTRjE83FqmQ6yeDaUDS3KTRhMV96h5TTSLD4HQ4uCE9bxePUU5pYL/3mD5o9CcMKgTONc39NNLrV5iK4aNLUoOWHQ38RQtW3nsm6db92i8ISvGBtct+hvwqyzBFxE9DehrcHlQPU1YWNvcNGirwlfNThv0ZOE9eJG1OsGZy36kVBdczU9e7RvAz5b9CFhqfIwSp4XwG+OwUWLPiRUV/33Z4tbGtTvGK635CfUDfb/SO5rt20N9t8m65fLT9g3GD5abDY2qC+lvEg4NjhEvLW4tUFvEj4a7OXq3TzoW8Jpg0PEzfk8SThv8EMeJFw1+O8SHmrQg4QHG/Qg4cEGxSc83KD4hIcblJ6w3L508TXh+vtDEpLw3GwDEpKQhOdznVD2fRr9tdpRw/1HqQndIeEvkXCXUlDC+1NBndsnge/fwyVnp9PGH3p95dm1WMKza4/fI37j+UPXR/c+2X9/hjQI0uO3LsyuMioM9A8Sjy/W1iIhY7Sn2tzpUahdWyXiNDNSxcWtSlCBAAAAAAAAAAAAAAAAAAAAAAAAAAAAwCn+AEXGNosxDBhFAAAAAElFTkSuQmCC">
                                        @else
                                            <img src="{{ route('images.get', ['image' => $album->getCover()]) }}" class="album-edit-image">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="color:black; text-decoration:none; font-size:13pt;">{{ $album->name }}</td>
                                </tr>
                            </table>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="new_album">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.albums.new') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">Új album létrehozása</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="name">Név<span class="required">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Név" class="form-control" required>
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
                    <input hidden type="text" name="gallery" value="{{ $gallery->id }}">
                </form>
            </div>
        </div>
    </div>
@endsection
