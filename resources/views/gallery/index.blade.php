@extends('layouts.main')

@section('galleries.active','active')

@section('title','Galériák')

@section('content')
    <h1 class="page-header">Albumok</h1>
        @if($albums->count()==0)

            <div class="row">
            <div class="col-md-4 col-md-push-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i>Nincs jelenleg album</i>
                        </h3>
                    </div>
                </div>
            </div>
            </div>
        @endif
    <?php $i = 0; ?>
        @foreach($albums as $album)
            <?php $i++;
            if($i%3==1){
                ?><div class="row">
            <?php
            }
            ?>
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
                <?php
                if($i%3==0){
                ?></div>
                <?php
                }
                ?>
        @endforeach
@endsection
