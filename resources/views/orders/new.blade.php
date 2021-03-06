@extends('layouts.main')

@section('title','Rendelés leadás')

@section('orders.new.active','active')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <form action="{{ route('orders.new.step2') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="form_type" value="first">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Rendelés leadása</h3>
                    </div>
                    <div class="panel-body include-progress">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width:33%" aria-valuenow="33">Első lépések</div>
                            <div class="progress-bar bg-default" style="width:33%">Minták hozzáadása</div>
                            <div class="progress-bar bg-default" style="width:34%">Mentés</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group @if(in_array('title',$error_fields)) has-error @endif">
                            <div class="input-group" data-toggle="tooltip" title="Adj neved a rendelésednek">
                                <label class="input-group-addon" for="title">Cím<span class="required">*</span></label>
                                <input required class="form-control" type="text" name="title" id="title" placeholder="Rendelés címe" value="{{ $title }}">
                            </div>
                            @if(in_array('title',$error_fields))
                                <span class="help-block">{{ $error_messages['title'] }}</span>
                            @endif
                        </div>
                        <div class="form-group @if(in_array('time_limit',$error_fields)) has-error @endif">
                            <div class="input-group">
                                <label class="input-group-addon" for="time_limit">Határidő</label>
                                <input min="{{ date('Y-m-d') }}" class="form-control" type="date" id="time_limit" name="time_limit" value="{{ $time_limit }}">
                            </div>
                            @if(in_array('time_limit',$error_fields))
                                <span class="help-block">{{ $error_messages['time_limit'] }}</span>
                            @endif
                        </div>
                        <div class="form-group @if(in_array('comment',$error_fields)) has-error @endif">
                            <div class="input-group" data-toggle="tooltip" title="Egyéb megjegyzés a rendeléssel kapcsolatban">
                                <label for="comment" class="input-group-addon">Megjegyzés</label>
                                <textarea name="comment" id="comment" class="form-control">{{ $comment }}</textarea>
                            </div>
                            @if(in_array('comment',$error_fields))
                                <span class="help-block">{{ $error_messages['comment'] }}</span>
                            @endif
                        </div>
                        <div class="checkbox">
                            <label for="public_albums"><input type="checkbox" name="public_albums" id="public_albums">Hozzájárulok ahhoz, hogy az elkészült rendelésemről készült képeket a weboldalon nyilvánosságra hozzuk.</label>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            Tovább &raquo;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
