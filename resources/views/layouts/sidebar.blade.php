<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Oldalak</h3>
    </div>
    <div class="panel-body sidebar-container">
        <ul class="sidebar">
            <li><a href="{{ route('members.index') }}" class="@yield('members.index.active')">Irányítópult</a></li>
            <li><a href="{{ route('members.unapproved') }}" class="@yield('members.unapproved.active')">
                    Elfogadásra váró rendelések
                    @if(\App\Models\Order::all()->where('approved_by',null)->count()!=0)
                    <span class="sidebar-notification">{{ \App\Models\Order::all()->where('approved_by',null)->count() }}</span>
                    @endif
                </a></li>
            <li><a href="{{ route('members.unassigned') }}" class="@yield('members.unassigned.active')">
                    Elvállalatlan rendelések
                    @if($send_orders_count!=0)
                        <span class="sidebar-notification">{{ $send_orders_count }}</span>
                    @endif
                </a></li>
            <li><a href="{{ route('members.mine') }}" class="@yield('members.mine.active')">
                        Saját rendeléseim
                    @if(Auth::user()->assignedOrders->count()!=0)
                        <span class="sidebar-notification">{{ Auth::user()->assignedOrders->where('archived',0)->where('joint',0)->count() }}</span>
                    @endif
                </a></li>
            <li><a href="{{ route('members.joint') }}" class="@yield('members.joint.active')">
                        Nagy közös projektek
                    @if($joint_orders_count>0)
                        <span class="sidebar-notification">{{ $joint_orders_count }}</span>
                    @endif
                </a></li>
            @if(Auth::user()->role_id>4)
                <li class="separator"></li>
                <li><a href="{{ route('members.active') }}" class="@yield('members.active.active')">Aktív rendelések</a></li>
                <li><a href="{{ route('members.archived') }}" class="@yield('members.archived.active')">Archivált rendelések</a></li>
            @endif
        </ul>
    </div>
</div>
