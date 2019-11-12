<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <script src="https://kit.fontawesome.com/492a2c0a6b.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    @include('layouts.nav')
    @yield('jumbotron')

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
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@yield('scripts')
</html>
