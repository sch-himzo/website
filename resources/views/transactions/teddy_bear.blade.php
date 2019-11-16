@extends('layouts.main')

@section('title',"Tranzakciók - $teddy->name")

@section('content')
    <h1 class="page-header">Tranzakciók - {{ $teddy->name }}</h1>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Tranzakciók</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Ki</th>
                    <th>Mikor</th>
                    <th>Mire</th>
                    <th>Mennyit</th>
                    <th>Műveletek</th>
                </tr>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->for }}</td>
                        <td>@if(!$transaction->in)- @endif{{ number_format($transaction->amount,0,',','.') }} Ft</td>
                        <td>
                            <span data-target="tooltip" title="Szerkesztés">
                                <button type="button" data-toggle="modal" data-target="#edit_transaction_{{ $transaction->id }}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </span>
                            <span data-target="tooltip" title="Törlés">
                                <button type="button" data-toggle="modal" data-target="#delete_transaction_{{ $transaction->id }}" class="btn btn-xs btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @foreach($transactions as $transaction)
        <div class="modal fade" id="edit_transaction_{{ $transaction->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('transactions.edit', ['transaction' => $transaction]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Tranzakció szerkesztése</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="teddy">Kassza</label>
                                    <input class="form-control" disabled readonly type="text" name="teddy" value="{{ $transaction->teddyBear->name }}" id="teddy">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="for">Leírás</label>
                                    <input class="form-control" type="text" name="for" id="for" value="{{ $transaction->for }}" placeholder="Leírás" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="amount">Összeg</label>
                                    <input class="form-control" type="number" name="amount" id="amount" value="@if(!$transaction->in){{ 0-$transaction->amount }}@else{{ $transaction->amount }}@endif" placeholder="Összeg" required>
                                    <label class="input-group-addon" for="amount">Ft</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Mentés" class="btn btn-primary">
                            <button class="btn btn-default" data-dismiss="modal" type="button">Mégse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete_transaction_{{ $transaction->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('transactions.delete', ['transaction' => $transaction]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">&times;</button>
                            <h4 class="modal-title">Tranzakció törlése</h4>
                        </div>
                        <div class="modal-body">
                            Biztosan törli a következő tranzakciót?<br>
                            <br>
                            <b>Összeg: </b>@if(!$transaction->in) - @endif {{ number_format($transaction->amount,0,',','.') }} Ft<br>
                            <b>Leírás: </b> {{ $transaction->for }}
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-danger" value="Igen">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Mégse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
