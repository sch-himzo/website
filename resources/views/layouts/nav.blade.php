<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('index') }}">Hímző</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="@yield('index.active')"><a class="@yield('index.active')" href="{{ route('index') }}">Főoldal</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li><a href="{{ route('logout') }}">Kijelentkezés</a></li>
                @else
                    <li><a href="#" data-toggle="modal" data-target="#login_modal">Bejelentkezés</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
