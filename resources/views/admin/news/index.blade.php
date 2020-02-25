@extends('layouts.main')

@section('title','Hírek')

@section('content')
    <h1 class="page-header with-description">Hírek &raquo; <a href="{{ route('admin.news.new') }}" type="button" class="btn btn-default btn-lg"><i class="fa fa-plus"></i> Új Hír</a></h1>
    <h2 class="page-description">
        <a href="{{ route('admin.index') }}">Vissza</a>
    </h2>

    {{ $news->links() }}
    @foreach($news as $news_item)
    <div class="row">
        <div class="col-md-12">
            <div class="panel @if($news_item->role_id>1) panel-info @else panel-default @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $news_item->title }}</h3>
                    <span style="font-size:10pt;">{{ \Carbon\Carbon::create($news_item->created_at)->diffForHumans() }}</span>
                </div>
                <div class="panel-body">
                    {!! $news_item->content !!}
                </div>
                <div class="panel-footer">
                    <a href="{{ route('admin.news.edit', ['news' => $news_item->id]) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Szerkesztés</a>
                    <button type="button" data-toggle="modal" data-target="#delete_news_{{ $news_item->id }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Törlés</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{ $news->links() }}
@endsection

@section('modals')
    @foreach($news as $news_item)
        <div class="modal fade" id="delete_news_{{ $news_item->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Hír törlése</h3>
                    </div>
                    <div class="modal-body">
                        <p>Biztosan törlöd ezt a hírt?</p>
                        {!! $news_item->content !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-times"></i> Mégse</button>
                        <a href="{{ route('admin.news.delete', ['news' => $news_item->id]) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Igen</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


