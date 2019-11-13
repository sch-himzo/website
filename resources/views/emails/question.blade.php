<h4>Kedves {{ $name }}!</h4>

<br>Rendeléseddel kapcsolatban a következő kérdés merült fel:

<br>{{ $message_a }}
<br>Erre az emailre válaszolva tudod elküldeni nekünk a válaszodat.


<h4>Rendelésed adatai:</h4>

<table>
    <tr>
        <th align="right">Név</th>
        <td>{{ $title }}</td>
    </tr>
    @if(isset($image))
    <tr>
        <th align="right">Kép</th>
        <td>
            <a href="{{ $image }}" style="text-decoration:none; color:#069;" target="_blank">Megnyitás</a>
        </td>
    </tr>
    @endif
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

<br>Üdvözlettel,
<br><i>Pulcsi és Foltmékör</i>
