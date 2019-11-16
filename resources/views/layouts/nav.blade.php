<nav class="navbar navbar-inverse navbar-static-top">
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
                @if(Auth::check())
                    <li class="dropdown @yield('orders.new.active')  @yield('user.orders.active') @yield('orders.unapproved.active') @yield('orders.active.active')">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Rendelések <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="@yield('orders.new.active')"><a class="@yield('orders.new.active') " href="{{ route('orders.new') }}">Új rendelés</a></li>
                            <li><a class="@yield('user.orders.active')" href="{{ route('user.orders') }}">Rendeléseim</a></li>
                            @if(Auth::user()->role_id>1)
                                <li role="separator" class="divider"></li>
                                <li class="@yield('orders.fake.active')"><a class="@yield('orders.fake.active')" href="{{ route('orders.fake') }}">Rendelés felvétele</a></li>
                                <li class="@yield('orders.unapproved.active')"><a href="{{ route('orders.unapproved') }}" class="@yield('orders.unapproved.active')">Elfogadásra váró rendelések</a></li>
                                <li class="@yield('orders.active.active')"><a href="{{ route('orders.active') }}">Aktív rendelések</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    @if(Auth::user()->role_id>3)
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Pénzügyek <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('transactions.teddy_bears') }}">Kasszák</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('logout') }}">Kijelentkezés</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="#" data-toggle="modal" data-target="#register_modal">Regisztráció</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#login_modal">Bejelentkezés</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
