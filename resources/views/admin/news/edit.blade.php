@extends('layouts.main')

@section('title', 'Új Hír létrehozása')

@section('content')
    <h1 class="page-header with-description">Hír szerkesztése</h1>
    <h2 class="page-description"><a href="{{ route('admin.news.index') }}">Vissza</a></h2>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Hír szerkesztése</h3>
                </div>
                <form action="{{ route('admin.news.push', ['news' => $news]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="title">Cím</label>
                                <input required type="text" class="form-control" id="title" name="title" value="{{ $news->title }}">
                            </div>
                        </div>
                        <textarea id="content" name="content">{{ $news->content }}</textarea>
                        <br>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="role">Csak körtagoknak?</label>
                                <select class="form-control" name="role" id="role" required>
                                    <option selected disabled>Válassz egyet</option>
                                    <option @if($news->role_id==1) selected @endif value="0">Nem</option>
                                    <option @if($news->role_id>1) selected @endif value="2">Igen</option>
                                </select>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label for="alert">
                                <input @if($news->alert) checked @endif type="checkbox" name="alert" id="alert">
                                Felugró ablakos értesítés a főoldalon
                            </label>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-default"><i class="fa fa-times"></i> Mégse</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Mentés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <script src="https://cdn.tiny.cloud/1/wc028qboinrvdg3ggxid8e3s2p020si194by6ownvr4tk2cr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content'
        });
    </script>
@endsection
