@extends('layouts.main')

@section('title','Pulcsi és Foltmékör')

@section('index.active','active')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
@endsection

@section('carousel')
    @if(!isset($_GET['page']) || $_GET['page']==1)
        <style>
        @foreach($slides as $slide)
        @media screen and (max-width:768px) {

            .slide-{{ $slide->id }}{
                background: url("{{ $slide->image }}") no-repeat center;
                background-size:cover;
            }
        }

        @media screen and (min-width:768px) {

            .slide-{{ $slide->id }}{
                background: url("{{ $slide->image }}") no-repeat center;
                background-size:contain;
            }
        }
        @endforeach

        .navbar{
            margin-bottom:0 !important;
        }

    </style>

    <div id="carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($slides as $slide)
                <li @if($slide->number==1) class="active" @endif data-target="carousel" data-slide-to="{{ $slide->number-1 }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($slides as $slide)
                <div class="item slide-{{ $slide->id }} @if($slide->number==1) active @endif">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>{{ $slide->title }}</h1>
                            {!! $slide->message !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a style="line-height:500px;" class="left carousel-control" href="#carousel" role="button" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a style="line-height:500px;" class="right carousel-control" href="#carousel" role="button" data-slide="next">
            <i class="fa fa-chevron-right"></i>
            <span class="sr-only">Next</span>
        </a>
    </div>
    @endif
@endsection

@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <input type="hidden" name="users_url" id="users_url" value="{{ route('getUsers') }}">
    <input type="hidden" name="current_user_id" id="current_user_id" value="@if(Auth::check()) {{ Auth::user()->id }} @else {{ false }} @endif">
    <div style="margin-top:20px;" class="row">
        <div class="col-md-9 col-md-push-3">
            @if(isset($_GET['page']) && $_GET['page']>1)
                {{ $news->links() }}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kik vannak most hímzőben?</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="users_table">
                    </table>
                </div>
                @if(Auth::check() && Auth::user()->role_id>1)
                    <div class="panel-footer" id="btn-container">

                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-9">
            @foreach($news as $article)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $article->title }} <i style="font-size:10pt;">- {{ \Carbon\Carbon::create($article->created_at)->diffForHumans() }}</i></h3>

                    </div>
                    <div class="panel-body">
                        {!! $article->content !!}
                    </div>
                </div>
            @endforeach
            {{ $news->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    @if(isset($login) && $login==1)
        <script>
            $('#login_modal').modal('show');
        </script>
    @endif
<script src="{{ asset('js/currently_in.js') }}"></script>
    @if(env('APP_DEBUG')=='true' && !Auth::check())
        <script>
            $('#warning').modal('toggle');
        </script>
    @endif
    @if(Auth::check() && Auth::user()->role_id>1 && Auth::user()->notifications_disabled!=1)
    <script>
        if(window.Notification){
            if(Notification.permission!=="granted"){
                $('#notifications').modal('toggle');
            }
        }

        function enableNotifications()
        {
            if(window.Notification){
                Notification.requestPermission(function(status){
                    let n = new Notification('Köszi', {body:'Értesítések bekapcsolva', dir:'ltr'})
                });
            }
        }
    </script>
    @endif
    @if(!Auth::check())
    <script>
        $('#current_news_article').modal('show');
    </script>
    @endif
@endsection

@section('modals')
    @if(Auth::check() && Auth::user()->role_id>1 && Auth::user()->notifications_disabled!=1)
        <div class="modal fade" id="notifications">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Értesítések engedélyezése</h4>
                    </div>
                    <div class="modal-body">
                        Kérlek engedélyezd az értesítéseket, hogy megtudd, hogy vége van-e egy hímzésnek :)
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="enableNotifications()" data-dismiss="modal" type="button">Engedélyezés</button>
                        <a class="btn btn-default" href="{{ route('user.disable_notifications') }}">Mégse</a>
                    </div>
                </div>

            </div>
        </div>
    @endif
    @foreach($news as $article)
        @if($article->alert)
            <div class="modal fade" id="current_news_article">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">&times;</button>
                            <h4 class="modal-title">{{ $article->title }}</h4>
                        </div>
                        <div class="modal-body">
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
