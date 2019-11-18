@extends('layouts.main')

@section('title',$order->title.' - Albumok')

@section('content')
    <h1 class="page-header">Rendeléshez tartozó albumok &raquo; {{ $order->title }} &raquo; <a href="javascript:history.back()">Vissza</a></h1>
    <div class="row">
        @foreach($albums as $album)
            @if($role >= $album->role_id)
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $album->name }}</h3>
                        </div>
                        <div class="table-responsive">
                            <a href="{{ route('albums.view', ['album' => $album]) }}">
                                <table class="table">
                                    <tr>
                                        <td align="center">
                                            <img src="{{ route('images.get', ['image' => $album->getCover()]) }}" class="album-edit-image">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="color:black; text-decoration:none; font-size:13pt;">{{ $album->name }}</td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
