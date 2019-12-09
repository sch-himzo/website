@extends('layouts.main')

@section('title','Rendelés leadás')

@section('orders.new.active','active')

@section('content')
    <div class="row">
        @if($group->orders->count()!=0)
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Eddigi minták</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed">
                            @foreach($group->orders as $order)
                                <tr>
                                    <td>{{ $order->title }}</td>
                                    <td id="gallery_{{ $order->id }}">
                                        @if(!$order->existing_design)
                                            <?php $i=0; ?>
                                            @foreach($order->images as $image)
                                                <a rel="lightbox[{{ $order->id }}]" href="{{ asset($image->getImage()) }}">
                                                <?php $i++; if($i==1){ ?>
                                                    <span class="btn btn-primary btn-xs" data-toggle="tooltip" title="Képek megtekintése" data-lightbox="{{ $order->id }}">
                                                        <i class="fa fa-image"></i>
                                                    </span>
                                                <?php } ?>
                                                </a>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <span data-toggle="tooltip" title="Törlés">
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_order_{{ $order->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-6 @if($group->orders->count()==0) col-md-push-3 @endif">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Minta hozzáadása</h3>
                </div>
                <form id="form" action="{{ route('orders.save', ['group' => $group]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="panel-body include-progress">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width:33%" aria-valuenow="33">Első lépések</div>
                            <div class="progress-bar" style="width:33%">Minták hozzáadása</div>
                            <div class="progress-bar bg-default" style="width:34%">Mentés</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Minta neve">
                                <label for="title" class="input-group-addon">Cím<span class="required">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" required placeholder="Cím">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label for="existing">
                                    <input type="checkbox" id="existing" name="existing">
                                    Már volt ilyen rendelve
                                </label>
                            </div>
                            <div class="input-group" data-toggle="tooltip" title="Válaszd ki a tervezendő folt mintáját">
                                <label id="image_label" class="input-group-addon" for="image">Tervrajzok<span class="required">*</span></label>
                                <input accept="image/*" required class="form-control" type="file" id="image" name="image[]" multiple>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Hány darabot szeretnél rendelni?">
                                <label class="input-group-addon" for="count">Darabszám<span class="required">*</span></label>
                                <input required class="form-control" type="number" id="count" name="count" placeholder="Darabszám">
                            </div>
                        </div>
                        <div class="form-group" data-toggle="tooltip" title="Foltot rendelsz, vagy pólóra/pulcsira hímzendő mintát?">
                            <input type="hidden" name="type" value="badge" id="order_type">
                            <input class="badge-select btn btn-primary left" type="button" value="Folt" id="badge_button"><input class="badge-select btn btn-default center" type="button" value="Pólóra" id="shirt_button"><input class="badge-select btn btn-default right" type="button" value="Pulcsira" id="jumper_button">
                        </div>

                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="A folt átmérője (cm-ben)">
                                <label id="size_label" class="input-group-addon" for="size">Méret<span class="required">*</span></label>
                                <input required class="form-control" type="text" name="size" id="size" placeholder="Méret">
                                <span class="input-group-addon">cm</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Ha különleges betűtípust igényel a folt">
                                <label id="font_label" class="input-group-addon" for="font">Betűtípus</label>
                                <input accept=".ttf" class="form-control" type="file" name="font" id="font">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group" data-toggle="tooltip" title="Szöveges leírás a folt elképzeléséről">
                                <label id="comment_label" class="input-group-addon" for="comment">Elképzelés<span class="required">*</span></label>
                                <textarea required name="comment" id="comment" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button id="more" type="button" class="btn btn-default">
                            További minta hozzáadása <i class="fa fa-plus"></i>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Véglegesítés <i class="fa fa-check"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection


@section('modals')
    @foreach($group->orders as $order)
        <div class="modal fade" id="delete_order_{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Minta törlése</h4>
                    </div>
                    <div class="modal-body">
                        <p>Biztosan törlöd ezt a mintát?</p>
                        <table class="table table-striped">

                            <tr>
                                <th>Cím</th>
                                <td>{{ $order->title }}</td>
                            </tr>
                            <tr>
                                <th>Elképzelés</th>
                                <td>{{ $order->comment }}</td>
                            </tr>
                            @if($order->existing)
                                <tr>
                                    <th>Létező minta</th>
                                    <td><i class="fa fa-check"></i></td>
                                </tr>
                            @else
                                <tr>
                                    <th>Képek</th>
                                    <td>
                                        <?php $i=0; ?>
                                        @foreach($order->images as $image)
                                            <a rel="lightbox[modal_{{ $order->id }}]" href="{{ asset($image->getImage()) }}">
                                                <?php $i++; if($i==1){ ?>
                                                <span class="btn btn-primary btn-xs" data-toggle="tooltip" title="Képek megtekintése1" data-lightbox="{{ $order->id }}">
                                                    <i class="fa fa-image"></i>
                                                </span>
                                                <?php } ?>
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cím</th>
                                    <td>{{ $order->title }}</td>
                                </tr>
                                <tr>
                                    <th>Darabszám</th>
                                    <td>{{ $order->count }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('orders.step2.delete', ['order' => $order]) }}" class="btn btn-danger">Igen <i class="fa fa-trash"></i></a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégse <i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script src="{{ asset('js/order.js') }}"></script>
    <script>
        $('#more').click(function(){
            $('#form').attr('action','{{ route('orders.step2', ['group' => $group]) }}');
            $('#form').submit();
        });
    </script>
@endsection
