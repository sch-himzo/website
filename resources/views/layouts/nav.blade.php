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
        <input type="hidden" id="pusher-id" value="{{ env('PUSHER_APP_KEY') }}">
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @if(Auth::check() && Auth::user()->role_id>1)
                    <li class="@yield('members.active')"><a class="@yield('members.active')" href="{{ route('members.index') }}">Irányítópult</a></li>
                @endif
                @if(Auth::check() && (Auth::user()->activated==1 || Auth::user()->internal_id!=null))
                    <li class="dropdown @yield('orders.new.active')  @yield('user.orders.active') @yield('orders.unapproved.active') @yield('orders.active.active')">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Rendelések <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->role_id<2)
                                <li class="@yield('orders.new.active')"><a class="@yield('orders.new.active') " href="{{ route('orders.new.create') }}">Új rendelés</a></li>
                            @elseif(Auth::user()->role_id>1)
                                <li class="@yield('orders.fake.active')"><a class="@yield('orders.fake.active')" href="{{ route('orders.new.fake') }}">Rendelés felvétele</a></li>
                            @endif
                            <li><a class="@yield('user.orders.active')" href="{{ route('user.orders') }}">Rendeléseim</a></li>
                        </ul>
                    </li>
                @endif
                <li class="@yield('galleries.active')"><a class="@yield('galleries.active')" href="{{ route('gallery.index') }}">Képek</a></li>
                <li class="@yield('faq.active')"><a class="@yield('faq.active')" href="{{ route('faq.index') }}">GYIK</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    @if(Auth::user()->role_id>1)
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="machine_dropdown"><i class="fa fa-cash-register"></i> &raquo; {{ $current_machine->getState() }} @if($current_machine->state==1) &raquo; {{ round(min($current_machine->current_stitch/$current_machine->total_stitches,1)*100,2) }}% @endif</a>
                            <ul class="dropdown-menu">
                                <li style="padding:10px; width:200px; margin-bottom:-15px;">
                                    <div class="progress">
                                        <div id="machine_progress" class="{{ $current_machine->getProgressBar() }}" style="text-align:center;width:{{ min($current_machine->current_stitch/$current_machine->total_stitches,1)*100 }}%">
                                            {{ round(min($current_machine->current_stitch/$current_machine->total_stitches,1)*100,2) }}%
                                        </div>
                                    </div>
                                </li>
                                <li style="padding:10px;" id="machine_state">
                                    {{ $current_machine->getState() }}
                                </li>
                                <li style="padding:10px;" id="machine_stitches">
                                    {{ $current_machine->total_stitches . "/" . $current_machine->current_stitch }} öltés
                                </li>
                                @if(Auth::user()->role_id >= $current_machine->viewable_by)
                                <li>
                                    <a href="{{ route('machines.status') }}">
                                        Megtekintés
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->role_id>3)
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Admin <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Pénzügyek</li>
                                <li><a href="{{ route('transactions.teddy_bears') }}">Kasszák</a></li>
                                @if(Auth::user()->role_id>4)
                                    <li class="divider" role="separator"></li>
                                    <li class="dropdown-header">Beállítások</li>
                                    <li>
                                        <a href="{{ route('admin.index') }}">Admin felület</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('user.profile') }}">Profilom</a></li>
                            @if(Auth::user()->role_id>1)
                                <li>
                                    <a href="{{ route('projects.index') }}">Projektjeim</a>
                                </li>
                            @endif
                            <li class="divider" role="separator"></li>
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
@if(Auth::check() && Auth::user()->role_id>1)
    <input type="hidden" id="asdf_url" value="{{ route('machines.getProgressBar') }}">
    <input type="hidden" id="asdf_token" value="{{ csrf_token() }}">
    <input type="hidden" id="asdf_state" value="{{ $current_machine->state }}">
@endif
