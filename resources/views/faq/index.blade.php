@extends('layouts.main')

@section('title','GYIK')

@section('faq.active','active')

@section('content')
    <h1 class="page-header">Gyakran ismételt kérdések @if(Auth::check() && Auth::user()->role_id>4) &raquo; <button type="button" data-toggle="modal" data-target="#new" class="btn btn-lg btn-default"><i class="fa fa-plus"></i> Új Kérdés</button> @endif</h1>
    <?php $i = 0; ?>
    @foreach($faqs as $faq)
        <?php $i++ ?>
        <?php if($i%3==1){
            ?>
            <div class="row">
        <?php
        }
        ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Q:</b> {{ $faq->question }}</h3>
                </div>
                <div class="panel-body">
                    <b>A: </b>{!! $faq->answer !!}
                </div>
                @if(Auth::check() && Auth::user()->role_id>4)
                    <div class="panel-footer">
                        <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit_{{ $faq->id }}">
                            <i class="fa fa-edit"></i> Szerkesztés
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete_{{ $faq->id }}">
                            <i class="fa fa-trash"></i> Törlés
                        </button>
                    </div>
                @endif
            </div>
        </div>
            <?php
            if($i%3==0){
                ?>
            </div>
            <?php
            }
            ?>
    @endforeach
@endsection

@section('modals')
    @if(Auth::check() && Auth::user()->role_id>4)
        @foreach($faqs as $faq)
            <div class="modal fade" id="edit_{{ $faq->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Kérdés szerkesztése</h4>
                        </div>
                        <form action="{{ route('faq.edit', ['faq' => $faq]) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="question_{{ $faq->id }}" class="input-group-addon">Kérdés<span class="required">*</span></label>
                                        <input value="{{ $faq->question }}" type="text" class="form-control" required placeholder="Kérdés" name="question_{{ $faq->id }}" id="question_{{ $faq->id }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="answer_{{ $faq->id }}" class="input-group-addon">Válasz<span class="required">*</span></label>
                                        <textarea class="form-control" id="answer_{{ $faq->id }}" name="answer_{{ $faq->id }}">{{ $faq->answer }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                                <input type="submit" class="btn btn-primary" value="Mentés">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="delete_{{ $faq->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Kérdés törlése</h4>
                        </div>
                        <div class="modal-body">
                            Biztosan törlöd ezt a kérdést?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                            <a class="btn btn-danger" href="{{ route('faq.delete', ['faq' => $faq]) }}">Igen</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <div class="modal fade" id="new">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Új kérdés hozzáadása</h4>
                </div>
                <form action="{{ route('faq.create') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="question" class="input-group-addon">Kérdés<span class="required">*</span></label>
                                <input type="text" class="form-control" required placeholder="Kérdés" name="question" id="question">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="answer" class="input-group-addon">Válasz<span class="required">*</span></label>
                                <textarea class="form-control" id="answer" name="answer"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                        <input type="submit" class="btn btn-primary" value="Mentés">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
