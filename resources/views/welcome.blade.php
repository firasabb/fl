@extends('layouts.welcome')

@section('content')
<div class="container">
    <div>
        @foreach($questions as $question)
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-img">
                                <a href="#"><img class="avatar-pic" src="{{ $question->user->avatar_url }}"/></a>
                            </div>
                            <div class="card-header-text">
                                <a href="#">{{ $question->user->name }}</a>
                            </div>
                            <div class="card-header-date">
                                <span>{{ $question->created_at->toDateString() }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$question->title}}</h5>
                            @if($question->description)
                                <p class="card-text">{{$question->description}}</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="card-footer-icons">
                                @svg('heart', 'heart-icon')
                            </div>
                            <div class="card-footer-report">
                                <span><a href="#">Report</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
