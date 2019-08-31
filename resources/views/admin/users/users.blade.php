@extends('admin.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <tr>
                            <th scope="col">
                                ID
                            </th>
                            <th scope="col">
                                Name
                            </th>
                            <th scope="col">
                                Email
                            </th>
                            <th scope="col">
                                Roles
                            </th>
                            <th scope="col">
                                Date Created
                            </th>
                            <th scope="col">
                                Date Updated
                            </th>
                            <th scope="col">
                                Actions
                            </th>   
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    <?php
                                        $roles = $user->roles;
                                        foreach ($roles as $role) {
                                            echo nl2br ( $role->name . ' ');
                                        }
                                    ?>
                                </td>
                                <td>
                                    {{$user->created_at}}
                                </td>
                                <td>
                                    {{$user->updated_at}}
                                </td>
                                <td>
                                    <a href="{{ url('admin/dashboard/user/' . $user->id) }}" class="btn btn-success">Show/Edit</a>
                                    <form action="{{ route('admin.delete.user', ['id' => $user->id]) }}" method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn waves-effect waves-light red" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
