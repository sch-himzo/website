<h4>Kedves {{ $user->name }}!</h4>

<br>A <b>{{ $order->title }}</b> nevű rendelés <b>archiválva</b> lett a weboldalon.

<br>Rendelés adatai:

<table>
    <tr>
        <th align="right">Megrendelő neve</th>
        <td>
            @if($order->user)
                {{ $order->user->name }}
            @elseif($order->tempUser)
                {{ $order->tempUser->name }}
            @else
                <i>N/A</i>
            @endif
        </td>
    </tr>
    <tr>
        <th align="right">Megrendelő email címe</th>
        <td>
            @if($order->user)
                {{ $order->user->email }}
            @elseif($order->tempUser)
                {{ $order->tempUser->email }}
            @else
                <i>N/A</i>
            @endif
        </td>
    </tr>
    <tr>
        <th align="right">Név</th>
        <td>{{ $order->title }}</td>
    </tr>
    <tr>
        <th align="right">Határidő</th>
        <td>{{ $order->time_limit }}</td>
    </tr>
    @if($order->comment)
        <tr>
            <th align="right">Megjegyzés</th>
            <td>{{ $order->comment }}</td>
        </tr>
    @endif
</table>

<br>A rendelést <a style="color:#069; text-decoration:none;" href="{{ route('orders.groups.view', ['group' => $order]) }}">itt</a> tudod megtekinteni.

<br>Puszipá,
<br><i>Pulcsi és Foltmékör</i>
