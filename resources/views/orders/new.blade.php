@extends('layouts.main')

@section('title','Rendelés leadás')

@section('orders.new.active','active')

@section('content')
    @if(!Auth::check())
        <div class="row">
            <div class="col-md-4 col-md-push-4">
                <div class="alert alert-info alert-dismissable">
                    <a href="#" data-dismiss="alert" class="close">&times;</a>
                    <h4><i class="fa fa-info-circle"></i>&nbsp;Jelentkezz be!</h4>
                    <p>Ha rendelést szeretnél leadni, akkor egyszerűbb ha <a href="#" data-toggle="modal" data-target="#login_modal">bejelentkezel</a> vagy <a href="#" data-toggle="modal" data-target="#register_modal">regisztrálsz</a></p>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <form action="{{ route('orders.save') }}" method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Rendelés leadása</h3>
                    </div>
                    <div class="panel-body">
                        @if(!Auth::check())
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="email">Email cím</label>
                                <input type="text" class="form-control" id="email">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
