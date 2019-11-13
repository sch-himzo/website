<h4>Kedves {{ $name }}!</h4>

<p>{{ $title }} nevű rendelésed el lett fogadva!</p>

<p>Hamarosan elkezd rendeléseddel foglalkozni egy körtagunk. Ha valamilyen kérdése van feléd a megadott email címeden fog keresni.</p>

<p>Rendelésed adatai:</p>

<table>
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

<p>Üdvözlettel,</p>
<p><i>Pulcsi és Foltmékör</i></p>
