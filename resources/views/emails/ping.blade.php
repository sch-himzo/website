<h4>Kedves {{ $user->name }}</h4>

Közelgő határidejű rendelésed van!<br>

Rendelés adatai:<br>
<table>
    <tr>
        <th align="right">Rendelés</th>
        <td>{{ $order->title }}</td>
    </tr>
    <tr>
        <th align="right">Megrendelő neve</th>
        <td>
            @if($order->user!=null)
                {{ $order->user->name }}
            @elseif($order->tempUser!=null)
                {{ $order->tempUser->name }}
            @else
                <i>Nincs megadva</i>
            @endif
        </td>
    </tr>
    <tr>
        <th align="right">Határidő</th>
        <td>{{ \Carbon\Carbon::create($order->time_limit)->diffForHumans() }}</td>
    </tr>
</table>

A rendelést <a style="color:#069;" href="{{ route('orders.view', ['order' => $order]) }}">itt</a> tudod megtekinteni, ha úgy érzed segítség kell, kattints <a style="color:#069;" href="{{ route('orders.help', ['order' => $order]) }}">ide</a>.<br>

Üdv,<br>
<i>Pulcsi és Foltmékör</i><br><br>

<i>Ha le szeretnél iratkozni ezekről az emailekről <a href="{{ route('user.disable_email',['token' => $user->generateEmailToken()]) }}" style="color:#069;">kattints ide.</a></i>
