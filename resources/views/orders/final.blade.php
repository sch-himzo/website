@extends('layouts.main')

@section('title','Rendelés véglegesítve')

@section('content')
    <h1 class="page-header with-description">Rendelés véglegesítve</h1>
    <h2 class="page-description">{{ $group->title }}</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Rendelés adatai</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th style="vertical-align:middle; text-align:right;" rowspan="2">Megrendelő</th>
                            <td>
                                @if($group->user!=null)
                                {{ $group->user->name }}
                                @elseif($group->tempUser!=null)
                                {{ $group->tempUser->name }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if($group->user!=null)
                                    {{ $group->user->email }}
                                @elseif($group->tempUser!=null)
                                    {{ $group->tempUser->email }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="vertical-align:middle; text-align:right;">Rendelés neve</th>
                            <td>{{ $group->title }}</td>
                        </tr>
                        <tr>
                            <th style="vertical-align:middle; text-align:right;">Határidő</th>
                            <td>{{ $group->time_limit }}</td>
                        </tr>
                        <tr>
                            <th style="vertical-align:middle; text-align:right;">Megjegyzés</th>
                            <td>{{ $group->comment }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align:middle; text-align:justify;">@if($group->public_albums) <b>Hozzájárulok,</b> @else <b>Nem járulok hozzá,</b> @endif hogy az elkészült rendelésekről készült képeket publikusan meg lehessen tekinteni a weboldalon</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Csatolt minták</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Megnevezés</th>
                            <th>Darabszám</th>
                            <th>Méret</th>
                            <th>Képek</th>
                            <th>Típus</th>
                            <th>Elképzelés</th>
                        </tr>
                        @foreach($group->orders as $order)
                            <tr>
                                <td>{{ $order->title }}</td>
                                <td>{{ $order->count }}</td>
                                @if($order->existing_design)
                                    <td align="center" colspan="4">
                                        <i class="fa fa-check"></i> Már létező rendelés
                                    </td>
                                @else
                                    <td>{{ $order->size }} cm</td>
                                    <td>
                                        <?php $i=0; ?>
                                        @foreach($order->images as $image)
                                            <a rel="lightbox[modal_{{ $order->id }}]" href="{{ asset($image->getImage()) }}">
                                                <?php $i++; if($i==1){ ?>
                                                <span class="btn btn-primary btn-xs" data-toggle="tooltip" title="Képek megtekintése" data-lightbox="{{ $order->id }}">
                                                    <i class="fa fa-image"></i>
                                                </span>
                                                <?php } ?>
                                            <lg/a>
                                        @endforeach
                                    </td>
                                    <td>{{ $order_types[$order->type] }}</td>
                                    <td>{{ $order->comment }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-push-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Hova tovább?</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-block btn-primary" href="{{ route('user.orders') }}">Rendeléseim</a>
                    <a class="btn btn-block btn-default" href="{{ route('index') }}">Főoldal</a>
                </div>
            </div>
        </div>
    </div>
@endsection
