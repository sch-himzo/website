<h4>Kedves {{ $name }}!</h4>

<br>Azért kapod ezt az emailt, mert leadtál egy rendelést a Pulcsi és Foltmékör <a style="text-decoration:none; color:#069;" href="http://himzo.sch.bme.hu">weboldalán.</a>

<br>Rendelésedet feldolgozuk, jelenleg elfogadásra vár egy körtag által, kérjük várj türelemmel!

<br>Rendelésed adatai:

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

<br>Köszönjük rendelésed, értesíteni fogunk ha elfogadásra kerül a rendelésed!

<br>Üdvözlettel,
<br><i>Pulcsi és Foltmékör</i>
