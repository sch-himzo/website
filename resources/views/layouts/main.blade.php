<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    </head>
    <body>
    @include('layouts.nav')
    @yield('jumbotron')

    <div class="container" role="main">
        @yield('content')
    </div>
    @yield('modals')
    </body>
</html>
