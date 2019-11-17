@extends('layouts.main')

@section('title','Pulcsi és Foltmékör')

@section('index.active','active')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
@endsection

@section('carousel')
    <style>
        .first-slide{
            background: url("https://www.cats.org.uk/media/2197/financial-assistance.jpg?width=1600") no-repeat center;
        }
        .second-slide{
            background: url("https://images2.minutemediacdn.com/image/upload/c_crop,h_1193,w_2121,x_0,y_175/f_auto,q_auto,w_1100/v1554921998/shape/mentalfloss/549585-istock-909106260.jpg") no-repeat center;
        }
        .third-slide{
            background:url("https://www.cats.org.uk/media/1400/choosing-a-cat.jpg?width=1600") no-repeat center;
        }

        .navbar{
            margin-bottom:0 !important;
        }

    </style>

    <div id="carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="carousel" data-slide-to="0" class="active"></li>
            <li data-target="carousel" data-slide-to="1"></li>
            <li data-target="carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active first-slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Pulcsi és foltmékör</h1>
                        <p>Üdvözöljük a pulcsi és foltmékör weboldlán! Itt leadhatja folt rendelését, illetve válogathat aktuális ajánlatunkból (mittudomén)</p>
                    </div>
                </div>
            </div>
            <div class="item second-slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Folt rendelés</h1>
                        <p>
                            @if(Auth::check())
                            <a class="btn btn-lg btn-primary" href="{{ route('orders.new') }}">Rendelés &raquo;</a>
                            @else
                            <a class="btn btn-lg btn-primary" href="#" data-toggle="modal" data-target="#login_modal">Rendelés &raquo;</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="item third-slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Pulóverek</h1>
                        <p>Ide jönnek majd a vikes pulcsik hogy miből mennyi van stb</p>
                    </div>
                </div>
            </div>
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
@endsection

@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <input type="hidden" name="users_url" id="users_url" value="{{ route('getUsers') }}">
    <input type="hidden" name="current_user_id" id="current_user_id" value="@if(Auth::check()) {{ Auth::user()->id }} @else {{ false }} @endif">
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
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/currently_in.js') }}"></script>
@endsection
