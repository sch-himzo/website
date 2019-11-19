@extends('layouts.main')

@section('title','Tervek - '.$group->name)

@section('designs.active','active')

@section('content')
    <h1 class="page-header with-description">Tervek &raquo; {{ $group->name }}</h1>
    <h2 class="page-description">
        <a href="{{ route('designs.index') }}">Tervek</a>
        @foreach($route as $i)
            @if($i->id != $group->id)
            &raquo; <a href="{{ route('designs.groups.view', ['group' => $i]) }}">{{ $i->name }}</a>
            @endif
        @endforeach &raquo;
        <button type="button" data-toggle="modal" data-target="#new_design" class="btn btn-default">
            <i class="fa fa-plus"></i> Új terv
        </button>
        <button type="button" data-toggle="modal" data-target="#new_group" class="btn btn-default">
            <i class="fa fa-plus"></i> Új mappa
        </button>
    </h2>
    @if($group->designs->count()==0 && $group->children->count()==0)
        <div class="col-md-4 col-md-push-4">
            <div class="panel panel-default">
                <div style="text-align:center;" class="panel-body">
                    <i>Üres mappa</i>
                </div>
            </div>
        </div>
    @endif
    <?php $i=0; ?>
    @foreach($group->children as $groupi)
        <?php $i++; if($i%3==1){ ?><div class="row"><?php } ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <a class="panel-link" href="{{ route('designs.groups.view',['group' => $groupi]) }}">
                        <div style="border-bottom:1px solid rgba(0,0,0,0.15); background:rgba(0,0,0,0.04" class="panel-heading">
                            <h3 class="panel-title">{{ $groupi->name }}</h3>
                        </div>
                        <div style="text-align:center;" class="panel-body">
                            @if($groupi->getCover()==null && $groupi->children->count()==0)
                                <i>Üres mappa</i>
                            @elseif($groupi->getCover()==null)
                                @foreach($groupi->children as $child)
                                    <p align="left"><i class="fa fa-folder"></i> {{ $child->name }}</p>
                                @endforeach
                            @else
                                @foreach($groupi->children as $child)
                                    <p align="left"><i class="fa fa-folder"></i> {{ $child->name }}</p>
                                @endforeach
                                @foreach($groupi->designs as $design)
                                    <p align="left"><i class="fa fa-file"></i> {{ $design->name }}</p>
                                @endforeach
                            @endif
                        </div>
                    </a>
                    @if($groupi->hasPermission(Auth::user()))
                    <div class="panel-footer">
                        <span data-toggle="tooltip" title="Törlés">
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_{{ $groupi->id }}"><i class="fa fa-trash"></i></button>
                        </span>
                        <span data-toggle="tooltip" title="Szerkesztés">
                            <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#edit_{{ $groupi->id }}"><i class="fa fa-edit"></i></button>
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            <?php if($i%3==0){ ?></div><?php } ?>
    @endforeach
    <?php $i = 0; ?>
    @foreach($group->designs as $design)
        <?php $i++; if($i%4==1){ ?><div class="row"><?php } ?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $design->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <p><i class="fa fa-file"></i> <a href="{{ route('designs.get', ['design' => $design]) }}">{{ $design->image }}</a></p>
                    </div>
                </div>
            </div>
        <?php if($i%4==0){ ?></div><?php } ?>
    @endforeach
@endsection

@section('modals')
    <div class="modal fade" id="new_design">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('designs.save', ['group' => $group]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title">Új terv</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="name">Név</label>
                                <input type="text" name="title" id="name" class="form-control" required placeholder="Terv neve">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="image">Kép</label>
                                <input type="file" name="image" id="image" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Mégse</button>
                        <input type="submit" class="btn btn-primary" value="Mentés">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new_group">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('designs.groups.new') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="parent" value="{{ $group->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Új mappa</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label class="input-group-addon" for="name">Név<span class="required">*</span></label>
                                <input name="name" id="name" type="text" placeholder="Név" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Mentés" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($group->children as $child)
        @if($child->hasPermission(Auth::user()))
        <div class="modal fade" id="edit_{{ $child->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('designs.groups.edit', ['group' => $child]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $child->name }} - Mappa szerkesztése</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-addon" for="name_{{ $child->id }}">Név<span class="required">*</span></label>
                                    <input value="{{ $child->name }}" type="text" name="name_{{ $child->id }}" id="name_{{ $child->id }}" class="form-control" placeholder="Mappa neve" required">
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
            <div class="modal fade" id="delete_{{ $child->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Mappa törlése</h4>
                        </div>
                        <div class="modal-body">
                            Biztosan törlöd ezt a mappát?
                            <br><b>MINDEN elveszik ebből a mappából!</b>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                            <a href="{{ route('designs.groups.delete',['group' => $child]) }}" class="btn btn-danger">Igen!</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
