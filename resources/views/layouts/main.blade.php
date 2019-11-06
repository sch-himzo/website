<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <script src="https://kit.fontawesome.com/492a2c0a6b.js" crossorigin="anonymous"></script>
    </head>
    <body>
    @include('layouts.nav')
    @yield('jumbotron')

    <div class="container-fluid" role="main">
        @yield('content')
    </div>
    @if(!Auth::check())
        <div class="modal fade" id="login_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Bejelentkezés</h4>
                    </div>
                    <div class="modal-body">
                        <a href="{{ route('auth.sch.redirect') }}" class="btn btn-lg btn-block btn-primary">Bejelentkezés AuthSCH-val</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @yield('modals')
    </body>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
</html>
