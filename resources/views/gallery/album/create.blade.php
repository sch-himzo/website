@extends('layouts.main')

@section('title','Új album létrehozása')

@section('content')
    <h1 class="page-header with-description">Új album létrehozása</h1>
    @if($order!=null)
        <h3 class="page-description">"{{ $order->title }}" rendeléshez</h3>
    @endif
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <h3 class="panel-title">Új album</h3>
                </div>
                <form action="{{ route('albums.new.step2', ['order' => $order]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="name">Cím<span class="required">*</span></label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Cím" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="images">Képek<span class="required">*</span></label>
                                <input type="file" id="images" class="form-control" name="images[]" multiple required>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('orders.active') }}" class="btn btn-default">Vissza</a>
                        <input class="btn btn-primary" type="submit" value="Következő &raquo;">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
