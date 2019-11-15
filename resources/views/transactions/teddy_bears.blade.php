@extends('layouts.main')

@section('title','Kasszák')

@section('content')
    <h1 class="page-header">Kasszák &raquo; <button data-toggle="modal" data-target="#new_teddy" type="button" class="btn btn-lg btn-default"><i class="fa fa-plus"></i> Új kassza</button></h1>
    <div class="row">
        @foreach($teddy_bears as $teddy)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $teddy->name }}</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Leírás</th>
                                <td>{{ $teddy->description }}</td>
                            </tr>
                            <tr>
                                <th>Egyenleg</th>
                                <td>{{ number_format($teddy->calculateBalance(),0,',','.') }} Ft</td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <input class="btn btn-primary" type="button" data-toggle="modal" data-target="#new_transaction_{{ $teddy->id }}" value="Új tranzakció">
                        <a href="{{ route('transactions.teddy_bear', ['teddy_bear' => $teddy]) }}" class="btn btn-default">Tranzakciók</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

@section('modals')
    @foreach($teddy_bears as $teddy)
        <div class="modal fade" id="new_transaction_{{ $teddy->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('transactions.teddy_bear.balance.add', ['teddy_bear' => $teddy]) }}" method="POST">
                        <input type="hidden" name="original_{{ $teddy->id }}" id="original_{{ $teddy->id }}" value="{{ $teddy->balance }}">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">&times;</button>
                            <h4 class="modal-title">Új tranzakció</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="teddy" class="input-group-addon">Kassza</label>
                                    <input id="teddy" type="text" readonly disabled class="form-control" value="{{ $teddy->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="balance_{{ $teddy->id }}" class="input-group-addon">Egyenleg</label>
                                    <input id="balance_{{ $teddy->id }}" type="text" readonly disabled class="form-control" value="{{ $teddy->balance }}">
                                    <label for="balance_{{ $teddy->id }}" class="input-group-addon">Ft</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="amount_{{ $teddy->id }}" class="input-group-addon">Összeg</label>
                                    <input placeholder="Összeg" id="amount_{{ $teddy->id }}" name="amount" type="number" size="5" class="form-control">
                                    <label for="amount_{{ $teddy->id }}" class="input-group-addon">Ft</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="for" class="input-group-addon">Leírás</label>
                                    <input placeholder="Leírás" id="for" name="for" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button value="Hozzáadás" class="btn btn-primary">Hozzáadás</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
<div class="modal fade" id="new_teddy">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('transactions.teddy_bear.new') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Új kassza hozzáadása</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon" for="name">Név<span class="required">*</span></label>
                            <input id="name" name="name" class="form-control" placeholder="Név" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon" for="description">Leírás<span class="required">*</span></label>
                            <input id="description" name="description" class="form-control" placeholder="Leírás" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group" data-toggle="tooltip" title="Milyen jogosultság kell ahhoz, hogy lásd ezt a kasszát">
                            <label class="input-group-addon" for="role">Minimum jogosultság<span class="required">*</span></label>
                            <select id="role" name="role" class="form-control" required>
                                <option disabled selected>Válassz ki egyet!</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon" for="balance">Kezdő egyenleg</label>
                            <input id="balance" name="balance" placeholder="Egyenleg" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Mentés">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/jew.js') }}"></script>
@endsection
