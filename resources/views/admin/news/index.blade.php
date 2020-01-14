@extends('layouts.main')

@section('title','Hírek')

@section('content')
    <h1 class="page-header with-description">Hírek</h1>
    <h2 class="page-description">
        <a href="{{ route('admin.index') }}">Vissza</a>
    </h2>
@endsection
