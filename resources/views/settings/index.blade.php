@extends('layouts.main')

@section('title','Főoldali beállítások')

@section('content')
    <h1 class="page-header">Főoldali beállítások</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Üzenetek</h3>
                </div>
                <div class="panel-body slides-panel">
                    @foreach($slides as $slide)
                        <a class="panel-button" href="#" data-toggle="modal" data-target="#slide_{{ $slide->id }}">{{ $slide->title }}</a>
                    @endforeach
                </div>
                <div class="panel-footer">
                    <a class="btn btn-default" href="#" data-toggle="modal" data-target="#new_slide">
                        <i class="fa fa-plus"></i> Új slide
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @foreach($slides as $slide)
        <div class="modal fade" id="slide_{{ $slide->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ $slide->title }}</h4>
                    </div>
                    <div style="text-align:center;" class="modal-body">
                        <img style="width:100%;" src="{{ $slide->image }}" alt="{{ $slide->name }}">
                        {!! $slide->message !!}
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('settings.index.slide.edit', ['slide' => $slide]) }}" class="btn btn-default">Szerkesztés</a>
                        <a href="{{ route('settings.index.slide.delete', ['slide' => $slide]) }}" class="btn btn-danger">Törlés</a>
                        @if($slide->number != 1)
                        <a href="{{ route('settings.index.slide.up', ['slide' => $slide]) }}" class="btn btn-default">
                            <i class="fa fa-arrow-up"></i>
                        </a>
                        @endif
                        @if($slide->number != $slides->count())
                        <a href="{{ route('settings.index.slide.down', ['slide' => $slide]) }}" class="btn btn-default">
                            <i class="fa fa-arrow-down"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="new_slide">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('settings.index.slides.new') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Új slide</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="title">Cím<span class="required">*</span></label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Cím" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="message">Üzenet<span class="required">*</span></label>
                                <textarea class="form-control" id="message" name="message" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="image">Kép<span class="required">*</span></label>
                                <input type="text" id="image" name="image" placeholder="Kép linkje" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Mentés" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
