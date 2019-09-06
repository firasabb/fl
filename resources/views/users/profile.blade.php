@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start profile-first-row">
        <div class="col-lg-2">
            <div class="profile-img">
                <img src="{{ $user->avatar_url }}" />
            </div>
        </div>
        <div class="col-lg-5 profile-text-col">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="profile-text">
                    <div class="profile-name">
                        <h3>{{ $user->name }}</h3>
                    </div>
                    <div class="profile-bio">
                        <p>{{ $user->bio }}</p>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
