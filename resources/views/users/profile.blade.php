@extends('layouts.app')

@section('content')
<div class="container profile-container">
    <div class="row justify-content-center profile-first-row">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="profile-container-header">
            <div class="row justify-content-center">
                <div class="col-lg-6 profile-text-col">
                    <div class="profile-img">
                        <img src="{{ $user->avatar_url }}" />
                    </div>
                    <div class="profile-text">
                        <div class="profile-name">
                            <h3>{{ $user->name }}</h3>
                        </div>
                        <div class="profile-bio">
                            <p>{{ $user->bio }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 profile-header-numbers">
                    <div class="profile-numbers text-center">
                        <h5>{{ count($user->arts->all()) }}</h5>
                        <h5>ARTS</h5>
                    </div>
                    <div class="profile-numbers text-center">
                        <h5>0</h5>
                        <h5>FOLLOWERS</h5>
                    </div>
                    <div class="profile-numbers text-center">
                        <h5>0</h5>
                        <h5>LIKES</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="arts-container">
            <div class="arts-container-title text-center">
                <h3>PUBLISHED ARTS</h3>
            </div>
            @if(!empty($user->arts))
            <div class="card-columns">
                @foreach($user->arts->all() as $art)
                <a href="{{ route('show.art', ['url' => $art->url]) }}" target="_blank" class="card-link">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ Storage::cloud()->url($art->covers->first()->url) }}" alt="{{ $art->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $art->title }}</h5>
                            <p class="card-text">{{ $art->description }}</p>
                        </div>
                        <div class="card-footer">
                            <div style="">
                                <small class="text-muted"><span class="footer-type">{{ ucwords($art->type->name) }}</span></small>
                            </div>
                            <div style="">
                                <small class="text-muted">{{ $art->created_at->toDateString() }}</small>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
