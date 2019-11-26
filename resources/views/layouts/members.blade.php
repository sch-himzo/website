<!DOCTYPE html>
<html lang="hu">
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}"/>
    <script src="https://kit.fontawesome.com/492a2c0a6b.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('styles')
</head>
<body>
@include('layouts.nav')
@yield('carousel')

<div class="container" role="main">
    @yield('page-title')
    <div class="row">
        <div class="col-sm-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-sm-9">
            @yield('content')
        </div>
    </div>
</div>
@yield('modals')
</body>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@if(session('party')=='on')
    <script>
        function getRandomInt(max) {
            return Math.floor(Math.random() * Math.floor(max));
        }

        $('i').addClass('fa-spin');
        setInterval(function(){
            r = getRandomInt(255);
            g = getRandomInt(255);
            b = getRandomInt(255);
            r2 = getRandomInt(255);
            g2 = getRandomInt(255);
            b2 = getRandomInt(255);
            $('body').css('background','rgb(' + r + ',' + g + ',' + b + ')');
            $('td').css('background','rgb(' + r2 + ',' + g2 + ',' + b2 + ')');
            $('th').css('background','rgb(' + r2 + ',' + g2 + ',' + b2 + ')');
            $('.panel-heading').css('background','rgb(' + r2 + ',' + g2 + ',' + b2 + ')');
        },50);
    </script>
    <audio src="{{ asset('spazz.mp3') }}"></audio>
@endif
@yield('scripts')
</html>
