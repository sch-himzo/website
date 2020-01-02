<h4>Kedves {{ $user->name }}!</h4>

{{ $order->title }} nevű rendelésed el lett fogadva!<br>
<br>
Hamarosan elkezd rendeléseddel foglalkozni egy körtagunk. Ha valamilyen kérdése van feléd a megadott email címeden fog keresni.<br>
<br>
<h3>Rendelésed adatai:</h3>

<table>
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
<br>
Üdvözlettel,<br>
<i>Pulcsi és Foltmékör</i>
