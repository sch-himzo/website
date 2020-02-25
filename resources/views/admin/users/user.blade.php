@extends('layouts.main')

@section('title','Admin')

@section('content')
    <h1 class="page-header with-description">{{ $user->name }}
        @if(Auth::id() == $user->id)
            <i class="fa fa-child" data-toggle="tooltip" title="Ez te vagy!"></i>
        @endif
    </h1>
    <h2 class="page-description"><a href="{{ route('admin.users.index') }}">Vissza</a></h2>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Felhasználó adatai</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Név</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Emailek engedélyezve</th>
                            <td>@if($user->allow_emails) Igen @else Nem @endif</td>
                        </tr>
                        <tr>
                            <th>Notik engedélyezve</th>
                            <td>@if(!$user->notifications_disabled) Igen @else Nem @endif</td>
                        </tr>
                        <tr>
                            <th>Jogosultság</th>
                            <td>@if($user->sticky_role || $user->role->id == 6) <b> {{$user->role->name}} </b> @else {{$user->role->name}} @endif @if(Auth::id() != $user->id)<button class="btn btn-xs btn-warning" type="button" data-toggle="modal" data-target="#edit_role">Szerkesztés <i class="fa fa-edit"></i></button>@endif</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {{ $orders->links() }}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Felhasználó rendelései</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @if ( $orders->count() == 0)
                            <tr>
                                <td align="center">Nincs megrendelés :(</td>
                            </tr>
                        @else
                            <tr>
                                <th>Cím</th>
                                <th>Komment</th>
                                <th>Állapot</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td><a href="{{route('orders.view', ['group' => $order])}}">{{ $order->title }}</a></td>
                                    <td>{{ $order->comment }}</td>
                                    <td>{{ $order->getStatusClient() }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
            {{ $orders->links() }}
        </div>
    </div>

@endsection

@section('modals')
    @if(Auth::id() != $user->id)
    <div class="modal fade" id="edit_role">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Jogosultság szerkesztése</h4>
                </div>
                <form action="{{ route('admin.users.edit', ['user' => $user]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="role" class="input-group-addon">Jogosultság</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option disabled selected>Válassz egyet!</option>
                                    @foreach(\App\Models\Role::all() as $role)
                                        <option @if($role->id == $user->role->id) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkbox">
                                <label><input @if($user->sticky_role) checked @endif name="sticky" type="checkbox" value="true">Sticky</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Mégse <i class="fa fa-times"></i></button>
                        <button type="submit" class="btn btn-primary">Mentés <i class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection
