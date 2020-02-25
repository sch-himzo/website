@extends('layouts.main')

@section('title','Admin - Emailek')

@section('content')
    <h1 class="page-header with-description">Elküldetlen emailek <span style="font-size:12pt"><i class="fa fa-question" data-toggle="tooltip" title="Ezek minden reggel 8-kor kerülnek elküldésre"></i></span></h1>
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
                    <div class="panel-footer">
                        <button type="button" data-toggle="modal" data-target="#delete_email_{{ $email->id }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash"></i> Törlés
                        </button>
                    </div>
                </div>
            @endforeach
            {{ $emails->links() }}
        </div>
    </div>
@endsection

@section('modals')
    @foreach($emails as $email)
        <div class="modal fade" id="delete_email_{{ $email->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">Email törlése</h4>
                    </div>
                    <div class="modal-body">
                        <p>Biztosan törlöd ezt az emailt?</p>
                        <p>Tárgy: <b>{{ $email->subject }}</b></p>
                        <p>Címzett: <b>{{ $email->to }}</b> <i>({{ $email->to_name }})</i></p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.emails.delete', ['email' => $email]) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Igen
                        </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times"></i> Mégse
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
