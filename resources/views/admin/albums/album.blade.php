@extends('layouts.main')

@section('title','Admin - Galériák - Albumok')

@section('content')
    <h1 class="page-header with-description">{{ $album->name }} &raquo;
        <a class="btn btn-lg btn-default" href="#" data-toggle="modal" data-target="#new_album"><i class="fa fa-plus"></i> Kép feltöltése</a>
    </h1>
    <h2 class="page-description">
        <a href="{{ route('admin.galleries.gallery', ['gallery' => $album->gallery]) }}">Vissza</a>
    </h2>

@endsection
