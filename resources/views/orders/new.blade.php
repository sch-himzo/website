@extends('layouts.main')

@section('title','Rendelés leadás')

@section('orders.new.active','active')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <form action="{{ route('orders.save') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Rendelés leadása</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Adj neved a rendelésednek">
                                <label class="input-group-addon" for="title">Cím<span class="required">*</span></label>
                                <input required class="form-control" type="text" name="title" id="title" placeholder="Rendelés címe">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Válaszd ki a tervezendő folt mintáját">
                                <label class="input-group-addon" for="image">Tervrajz<span class="required">*</span></label>
                                <input required class="form-control" type="file" id="image" name="image">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Hány darabot szeretnél rendelni?">
                                <label class="input-group-addon" for="count">Darabszám<span class="required">*</span></label>
                                <input class="form-control" type="number" id="count" name="count" placeholder="Darabszám">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="time_limit">Határidő</label>
                                <input class="form-control" type="date" id="time_limit" name="time_limit">
                            </div>
                        </div>
                        <div class="form-group" data-toggle="tooltip" title="Foltot rendelsz, vagy pólóra/pulcsira hímzendő mintát?">
                            <input type="hidden" name="type" value="badge" id="order_type">
                            <input class="badge-select btn btn-primary left" type="button" value="Folt" id="badge_button"><input class="badge-select btn btn-default center" type="button" value="Pólóra" id="shirt_button"><input class="badge-select btn btn-default right" type="button" value="Pulcsira" id="jumper_button">
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="A folt átmérője (cm-ben)">
                                <label class="input-group-addon" for="size">Méret<span class="required">*</span></label>
                                <input class="form-control" type="text" name="size" id="size" placeholder="Méret">
                                <span class="input-group-addon">cm</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Ha különleges betűtípust igényel a folt">
                                <label class="input-group-addon" for="font">Betűtípus</label>
                                <input class="form-control" type="file" name="font" id="font">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Egyéb megjegyzés a rendeléssel kapcsolatban">
                                <label for="comment" class="input-group-addon">Megjegyzés</label>
                                <textarea name="comment" id="comment" class="form-control"></textarea>
                            </div>
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
@endsection
