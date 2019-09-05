@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-light question-card">
                <div class="card-header bg-light">
                    <a><img class="avatar-pic" src=""/></a>
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
</div>
@endsection
