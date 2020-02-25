@extends('layouts.main')

@section('title','Rendelés felvétele')

@section('orders.new.active','active')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <form action="{{ route('orders.new.step2') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="form_type" value="first">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="url" value="{{ route('user.find') }}">
                <input type="hidden" name="user_id" id="user_id" value="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Rendelés felvétele</h3>
                        <i>(Más nevében)</i>
                    </div>
                    <div class="panel-body include-progress">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width:33%" aria-valuenow="33">Első lépések</div>
                            <div class="progress-bar bg-default" style="width:33%">Minták hozzáadása</div>
                            <div class="progress-bar bg-default" style="width:34%">Mentés</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <h3 class="page-header" style="margin-top:0">Megrendelő adatai</h3>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Kinek a nevében adod le a rendelést?">
                                <label class="input-group-addon" for="name">Név<span class="required">*</span></label>
                                <input required class="form-control" type="text" name="name" id="name" placeholder="Név">
                                <div class="autocomplete" id="autocomplete">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Azé akinek a nevében leadod a rendelést">
                                <label class="input-group-addon" for="email">Email cím<span class="required">*</span></label>
                                <input required class="form-control" type="email" name="email" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <h3 class="page-header" style="margin-top:0">Rendelés adatai</h3>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Adj neved a rendelésednek">
                                <label class="input-group-addon" for="title">Cím<span class="required">*</span></label>
                                <input required class="form-control" type="text" name="title" id="title" placeholder="Rendelés címe">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="time_limit">Határidő</label>
                                <input min="{{ date('Y-m-d') }}" class="form-control" type="date" id="time_limit" name="time_limit">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Egyéb megjegyzés a rendeléssel kapcsolatban">
                                <label for="comment" class="input-group-addon">Megjegyzés</label>
                                <textarea name="comment" id="comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label for="public_albums"><input type="checkbox" name="public_albums" id="public_albums">Hozzájárulok ahhoz, hogy az elkészült rendelésemről készült képeket a weboldalon nyilvánosságra hozzuk.</label>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="Submit" value="Mentés" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/order.js') }}"></script>
    <script src="{{ asset('js/fake.js') }}"></script>
@endsection
