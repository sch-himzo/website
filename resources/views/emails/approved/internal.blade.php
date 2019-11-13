<h4>Csumpalumpa!</h4>

<p><span style="font-weight:bold; color:red;">FONTOS!</span> Ezt az emailt nem te fogod kapni, csak amíg teszteljük a weboldalt nem akarom spamelni a <b>himzo@</b>-ot. Ez oda fog majd menni.</p>

<p>A <b>{{ $title }}</b> nevű rendelés el lett fogadva a weboldalon <b>{{ $approver->name }}</b> által.</p>

<p>A megrendelő kapott erről értesítést.</p>

<p>Rendelés adatai:</p>

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

<p>A rendelést <a style="color:#069; text-decoration:none;" href="http://himzo.sch.bme.hu/orders/active">itt</a> tudod megtekinteni, illetve bekerült
    <a style="color:#069; text-decoration:none;" href="https://trello.com/b/NLkjVmpG/rendel%C3%A9sek">Trellóba</a> is.</p>

<p>Üdvözlettel,</p>
<p><i>Pulcsi és Foltmékör</i></p>
