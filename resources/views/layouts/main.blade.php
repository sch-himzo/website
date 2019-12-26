<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}"/>
        <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
        <script src="https://kit.fontawesome.com/492a2c0a6b.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @yield('styles')
    </head>
    <body>
    @include('layouts.nav')
    @yield('carousel')

    <div class="container" role="main">
        @yield('content')
    </div>
    @if(!Auth::check())
        <div class="modal fade" id="login_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Bejelentkezés</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('auth.login') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email cím">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="password_login">Jelszó</label>
                                    <input type="password" class="form-control" id="password_login" name="password" placeholder="Jelszó">
                                </div>
                            </div>
                            <input type="submit" class="btn btn-lg btn-block btn-primary" value="Bejelentkezés">
                        </form>
                        <br><br>
                        <a href="{{ route('auth.sch.redirect') }}" class="btn btn-lg btn-block btn-default">Bejelentkezés AuthSCH-val</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="register_modal">
            <div class="modal-dialog">
                <form action="{{ route('auth.register') }}" method="POST">
                    <input type="hidden" name="register_url" value="{{ route('auth.email') }}" id="register_url">
                    <input type="hidden" name="password_url" value="{{ route('auth.password') }}" id="password_url">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Regisztráció</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="name">Teljes név<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Név" required>
                                </div>
                            </div>
                            <div class="form-group" id="email_group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="email_register">Email cím<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email_register" placeholder="Email" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group" id="password_group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="password">Jelszó<span class="required">*</span></label>
                                    <input class="form-control" type="password" placeholder="Jelszó" name="password" id="password">
                                </div>
                                <div id="requirements" class="requirements">
                                        <p id="number"><i id="number_response" class="fa fa-times"></i> Minimum 3 szám</p>
                                        <p id="capitals"><i id="capitals_response" class="fa fa-times"></i> Minimum 1 nagybetű</p>
                                        <p id="specials"><i id="specials_response" class="fa fa-times"></i> Minimum 1 speciális karakter</p>
                                        <p id="length"><i id="length_response" class="fa fa-times"></i> Minimum 8 karakter hosszú</p>
                                </div>
                            </div>
                            <div class="form-group" id="password2_group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="password2">Jelszó megint<span class="required">*</span></label>
                                    <input class="form-control" type="password" placeholder="Jelszó" name="password2" id="password2">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input id="submit_button" type="submit" class="btn btn-primary" value="Regisztrálok!" disabled>
                            <button type="button" data-dismiss="modal" class="btn btn-default">Mégse</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @yield('modals')
    </body>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/lightbox.js') }}"></script>
    @if(Auth::check() && Auth::user()->role_id>1)
        <script src="{{ asset('js/machine.js') }}"></script>
    @endif
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
    @if(session('party')=='on')
        <script>
            function getRandomInt(max) {
                return Math.floor(Math.random() * Math.floor(max));
            }

            $('i').addClass('fa-spin');
            setInterval(function(){
                r = getRandomInt(255);
                g = getRandomInt(255);
                b = getRandomInt(255);
                r2 = getRandomInt(255);
                g2 = getRandomInt(255);
                b2 = getRandomInt(255);
                $('body').css('background','rgb(' + r + ',' + g + ',' + b + ')');
                $('td').css('background','rgb(' + r2 + ',' + g2 + ',' + b2 + ')');
                $('th').css('background','rgb(' + r2 + ',' + g2 + ',' + b2 + ')');
                $('.panel-heading').css('background','rgb(' + r2 + ',' + g2 + ',' + b2 + ')');
            },50);
            setInterval(function(){
                $('.col-md-3').css('position','relative');
                $('.col-md-3').css('top',200-getRandomInt(400) + 'px');
                $('.col-md-3').css('left',200-getRandomInt(400) + 'px');
                $('.col-md-3').css('transition-property','top,left,transform');
                $('.col-md-3').css('transition-duration','1s,1s,1s');
                $('.col-md-3').css('transform','rotate(' + getRandomInt(360) + 'deg)');
                $('.col-sm-3').css('position','relative');
                $('.col-sm-3').css('top',200-getRandomInt(400) + 'px');
                $('.col-sm-3').css('left',200-getRandomInt(400) + 'px');
                $('.col-sm-3').css('transition-property','top,left,transform');
                $('.col-sm-3').css('transition-duration','1s,1s,1s');
                $('.col-sm-3').css('transform','rotate(' + getRandomInt(360) + 'deg)');
                $('.col-md-4').css('position','relative');
                $('.col-md-4').css('top',200-getRandomInt(400) + 'px');
                $('.col-md-4').css('left',200-getRandomInt(400) + 'px');
                $('.col-md-4').css('transition-property','top,left,transform');
                $('.col-md-4').css('transition-duration','1s,1s,1s');
                $('.col-md-4').css('transform','rotate(' + getRandomInt(360) + 'deg)');
                $('.col-md-6').css('position','relative');
                $('.col-md-6').css('top',200-getRandomInt(400) + 'px');
                $('.col-md-6').css('left',200-getRandomInt(400) + 'px');
                $('.col-md-6').css('transition-property','top,left,transform');
                $('.col-md-6').css('transition-duration','1s,1s,1s');
                $('.col-md-6').css('transform','rotate(' + getRandomInt(360) + 'deg)');
                $('.col-md-12').css('position','relative');
                $('.col-md-12').css('top',200-getRandomInt(400) + 'px');
                $('.col-md-12').css('left',200-getRandomInt(400) + 'px');
                $('.col-md-12').css('transition-property','top,left,transform');
                $('.col-md-12').css('transition-duration','1s,1s,1s');
                $('.col-md-12').css('transform','rotate(' + getRandomInt(360) + 'deg)');
            },1000);
            $('a').css('top',0);

            $('a').hover(function(){
                $(this).css('background','black');
                $(this).css('position','relative');
                $(this).css('transition-property','top');
                $(this).css('transition-duration','2s');
                $(this).css('top','2000px');
            });
        </script>
        <style>@keyframes marquee{
                   0% { left:0; }
                   100% { left:-100%;}
               }
        </style>
        <audio autoplay loop>
            <source src="{{ asset('spazz.mp3') }}">
        </audio>
    @endif
@yield('scripts')
</html>
