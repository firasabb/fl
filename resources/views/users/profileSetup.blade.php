@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('user.profile.setup', ['username' => $user->username]) }}" enctype="multipart/form-data">
{!! csrf_field() !!}
{!! method_field('PUT') !!}

    <div class="container">
        <div class="profile-container">
            <div class="row justify-content-center profile-first-row">
                <div class="col">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="profile-setup-info">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="text-center">
                                    <h3>INFO</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center profile-picture-container">
                            <div class="col">
                                <div class="form-row justify-content-center">
                                    <div class="col-md-4 mb-3">
                                        <label for="profile picture">Profile Picture:</label>
                                        <input id="profile-picture-select" name="profile_picture" type="file">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Name:</label>
                                        <input name="name" type="text" value="{{ $user->name }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row justify-content-center">
                                    <div class="col-md-6">
                                        <label for="bio">Bio:</label>
                                        <textarea name="bio" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-row justify-content-center mt-3">
                                    <div class="col-md-6">
                                        <label for="patreon">Paypal:</label>
                                        <input name="paypal" class="form-control" placeholder="If you would like to receive donations, add your Paypal email.">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <profile-links></profile-links>
        <div class="setup-btn-container">
            <button type="button" class="btn btn-blue btn-lg btn-block" v-on:click="addLink">Submit</button>
        </div>
    </div>
</form>
@endsection
