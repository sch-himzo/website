@extends('layouts.main')

@section('title','Album - '.$album->name)

@section('galleries.active','active')

@section('content')
    <h1 class="page-header with-description">Album megtekintése &raquo; <a href="javascript:history.back()">Vissza</a></h1>
    <h2 class="page-description">{{ $album->name }}</h2>
        <?php $i = 0; ?>
        @foreach($album->images as $image)
            <?php $i++;
            if($i%3==1){
                ?><div class="row"><?php
            }?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a target="_bank" href="{{ route('images.get', ['image' => $image]) }}">
                            <img class="album-edit-image" src="{{ route('images.get',['image' => $image]) }}" alt="{{ $image->title }}">
                        </a>
                        <h3 class="panel-title">{{ $image->title }}</h3>
                        <p>{{ $image->description }}</p>
                    </div>
                </div>
            </div>
                    <?php
                    if($i%3==0){
                    ?></div><?php
                    }
                    ?>
        @endforeach
@endsection
