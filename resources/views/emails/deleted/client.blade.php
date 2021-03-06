<h4>Kedves {{ $name }}!</h4>

<br>{{ $title }} nevű rendelésed törölve lett az alábbi indoklással:
<br>{{ $reason }}
<br>


<h4>Rendelésed adatai:</h4>

<table>
    <tr>
        <th align="right">Név</th>
        <td>{{ $title }}</td>
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

<br>Üdvözlettel,
<br><i>Pulcsi és Foltmékör</i>
