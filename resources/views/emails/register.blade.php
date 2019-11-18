<h4>Kedves {{ $user->name }}!</h4>

<br>Köszönjük regisztrációját a <a style="text-decoration:none; color:#069;" href="http://himzo.sch.bme.hu">Pulcsi és Foltmékör weboldalán</a>!

<br>Mielőtt rendelést adhat le, <a style="text-decoration:none; color:#069;" href="http://himzo.sch.bme.hu/activate/{{ $user->activate_token }}">aktiválnia</a> kell felhasználóját!

<br>Ezt erre a linkre kattintva teheti meg:
<br><a style="text-decoration:none; color:#069;" href="http://himzo.sch.bme.hu/activate/{{ $user->activate_token }}">http://himzo.sch.bme.hu/user/activate/{{ $user->activate_token }}</a>

<br>Üdvözlettel,
<br><i>Pulcsi és Foltmékör</i>
