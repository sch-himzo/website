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
                </tr>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->for }}</td>
                        <td>@if(!$transaction->in)- @endif{{ number_format($transaction->amount,0,',','.') }} Ft</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
