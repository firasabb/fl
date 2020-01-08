@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-light question-card">
                <div class="card-header bg-light">
                    <div class="card-header-flex">
                        <div class="card-header-img">
                            <a href="#"><img class="avatar-pic" src="{{ $question->user->avatar_url }}"/></a>
                        </div>
                        <div class="card-header-text">
                            <a href="#">{{ $question->user->name }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h2 class="card-title">{{$question->title}}</h2>
                    @if($question->description)
                        <p class="card-text">{{$question->description}}</p>
                    @endif
                </div>
                <div class="card-footer bg-light">@svg('heart', 'heart-icon')</div>
            </div>
        </div>
    </div>
    
    @auth
        @if(empty($question->answers->where('user_id', Auth::user()->id)->first()))
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('add.answer', ['encryptedId' => encrypt($question->id)]) }}">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" name="title" type="text" value="{{ old('title') }}" />
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        @endif
    @endauth
        
    @foreach($question->answers as $answer)
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-1">
                        @svg('thumbs-up', 'heart-icon')
                        @svg('thumbs-down', 'heart-icon')
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <h5 class="card-title">{{ $answer->title }}</h5>
                            <p class="card-text">{{ $answer->description }}</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
        </div>
    </div>
</div>
@endsection
