@extends('layouts.main')

@section('title','Admin - Emailek')

@section('content')
    <h1 class="page-header with-description">Elküldött emailek</h1>
    <h2 class="page-description">
        <a href="{{ route('admin.emails.index') }}">Vissza</a>
    </h2>

    <div class="row">
        <div class="col-md-12">
            {{ $emails->links() }}
            @foreach($emails as $email)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i>{{ $email->to }}</i> - {{ $email->subject }}</h3>
                    </div>
                    <div class="panel-body">
                        {!! $email->message !!}
                    </div>
                </div>
            @endforeach
            {{ $emails->links() }}
        </div>
    </div>
@endsection

