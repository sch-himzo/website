@extends('layouts.main')

@section('title','Profilom')

@section('content')
    <h1 class="page-header">Profilom</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Profilom</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ Auth::user()->email }} @if(Auth::user()->allow_emails) <i data-toggle="tooltip" title="Emailek engedélyezve" class="fa fa-check"></i> @else <i data-toggle="tooltip" title="Emailek kikapcsolva" class="fa fa-times"></i> @endif</td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">
                    @if(Auth::user()->allow_emails)
                        <a href="{{ route('user.emails.disable') }}" class="btn btn-xs btn-danger">
                            <i class="fa fa-times"></i> Emailek kikapcsolása
                        </a>
                    @else
                        <a href="{{ route('user.emails.enable') }}" class="btn btn-xs btn-success">
                            <i class="fa fa-check"></i> Emailek bekapcsolása
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
