<h4>Csumpalumpa!</h4>

<br>Rendelés lett leadva a <a style="text-decoration:none; color:#069;" href="http://himzo.sch.bme.hu">weboldalon.</a>

<br>A megrendelő jelenleg arra vár, hogy valaki elfogadja ezt.

<br>Rendelés adatai:

<table>
    <tr>
        <th align="right">Megrendelő neve</th>
        <td>{{ $user_name }}</td>
    </tr>
    <tr>
        <th align="right">Megrendelő email címe</th>
        <td>{{ $user_email }}</td>
    </tr>
    <tr>
        <th align="right">Név</th>
        <td>{{ $title }}</td>
    </tr>
    <tr>
        <th align="right">Kép</th>
        <td>
            <a href="{{ $image }}" style="text-decoration:none; color:#069;" target="_blank">Megnyitás</a>
        </td>
    </tr>
    <tr>
        <th align="right">Határidő</th>
        <td>{{ $time_limit }}</td>
    </tr>
    <tr>
        <th align="right">Darabszám</th>
        <td>{{ $count }}</td>
    </tr>
    <tr>
        <th align="right">Típus</th>
        <td>{{ $types[$type] }}</td>
    </tr>
    <tr>
        <th align="right">Méret</th>
        <td>{{ $size }}</td>
    </tr>
    @if(isset($font))
        <tr>
            <th align="right">Betűtípus</th>
            <td>{{ $font }}</td>
        </tr>
    @endif
    @if(isset($comment))
        <tr>
            <th align="right">Megjegyzés</th>
            <td>{{ $comment }}</td>
        </tr>
    @endif
</table>

<br>A rendelést itt tudod megtekinteni: <a style="color:#069; text-decoration:none;" href="http://himzo.sch.bme.hu/orders/unapproved">Elfogadásra váró rendelések</a>

<br>Üdvözlettel,
<br><i>Pulcsi és Foltmékör</i>
