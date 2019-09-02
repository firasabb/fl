@extends('admin.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$user->name}}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.edit.user', ['id' => $user->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control enabled-disabled" type="text" name="name"  value="{{ $user->name }}" placeholder="Name" disabled/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control enabled-disabled" type="email" name="email"  value="{{ $user->email }}" placeholder="Email" disabled/>
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <select multiple class="form-control enabled-disabled" id="usersSelect" name="roles[]" disabled>
                                        @foreach($roles as $role)
                                            <option <?php $user->hasRole($role->name) ? print('selected') : print(' ')  ?> value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary submit-edit-btn enabled-disabled" disabled>Submit</button>
                                <button type="button" class="btn btn-danger submit-edit-btn enabled-disabled" disabled>Generate Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="block-button">
                <button type="button" class="btn btn-success btn-lg btn-block" id="edit-button">Edit User</button>
                <button type="button" class="btn btn-danger btn-lg btn-block">Delete User</button>
            </div>

        </div>
    </div>
</div>
@endsection
