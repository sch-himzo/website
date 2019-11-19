@extends('layouts.main')

@section('title','Tervek')

@section('designs.active','active')

@section('content')
    <h1 class="page-header">Tervek &raquo;
        <button type="button" data-toggle="modal" data-target="#new_group" class="btn btn-lg btn-default">
            <i class="fa fa-plus"></i> Új mappa
        </button>
    </h1>
    <?php $i=0; ?>
    @foreach($design_groups as $group)
        <?php $i++; if($i%3==1){ ?><div class="row"><?php } ?>
            <div class="col-md-4">
                    <div class="panel panel-default">
                        <a class="panel-link" href="{{ route('designs.groups.view',['group' => $group]) }}">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $group->name }}</h3>
                        </div>
                        <div style="text-align:center;" class="panel-body">
                            @if($group->getCover()==null && $group->children->count()==0)
                                <i>Üres mappa</i>
                            @elseif($group->getCover()==null)
                                @foreach($group->children as $child)
                                    <p align="left"><i class="fa fa-folder"></i> {{ $child->name }}</p>
                                @endforeach
                            @else
                                @foreach($group->children as $child)
                                    <p align="left"><i class="fa fa-folder"></i> {{ $child->name }}</p>
                                @endforeach
                                @foreach($group->designs as $design)
                                    <p align="left"><i class="fa fa-image"></i> {{ $design->name }}</p>
                                @endforeach
                            @endif
                        </div>
                        </a>
                        @if($group->hasPermission(Auth::user()))
                            <div class="panel-footer">
                                <span data-toggle="tooltip" title="Törlés">
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_{{ $group->id }}"><i class="fa fa-trash"></i></button>
                                </span>
                                <span data-toggle="tooltip" title="Szerkesztés">
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#edit_{{ $group->id }}"><i class="fa fa-edit"></i></button>
                                </span>
                            </div>
                        @endif
                    </div>

            </div>
        <?php if($i%3==0){ ?></div><?php } ?>
    @endforeach
@endsection

@section('modals')
    <div class="modal fade" id="new_group">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('designs.groups.new') }}" method="POST">
                    {{ csrf_field() }}
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
    @foreach($design_groups as $child)
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
