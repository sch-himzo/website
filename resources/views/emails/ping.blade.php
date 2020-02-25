<h4>Kedves {{ $user->name }}</h4>

Közelgő határidejű rendelésed van!<br>

Rendelés adatai:<br>
<table>
    <tr>
        <th align="right">Rendelés</th>
        <td>{{ $group->title }}</td>
    </tr>
    <tr>
        <th align="right">Megrendelő neve</th>
        <td>
            @if($group->user!=null)
                {{ $group->user->name }}
            @elseif($group->tempUser!=null)
                {{ $group->tempUser->name }}
            @else
                <i>Nincs megadva</i>
            @endif
        </td>
    </tr>
    <tr>
        <th align="right">Határidő</th>
        <td>{{ \Carbon\Carbon::create($group->time_limit)->diffForHumans() }}</td>
    </tr>
</table>

A rendelést <a style="color:#069;" href="{{ route('orders.groups.view', ['group' => $group]) }}">itt</a> tudod megtekinteni@if(!$group->help), ha úgy érzed segítség kell, kattints <a style="color:#069;" href="{{ route('groups.help', ['order' => $group]) }}">ide</a>@endif.<br>

Üdv,<br>
<i>Pulcsi és Foltmékör</i><br><br>

<i>Ha le szeretnél iratkozni ezekről az emailekről <a href="{{ route('user.disable_email',['token' => $user->generateEmailToken()]) }}" style="color:#069;">kattints ide.</a></i>
