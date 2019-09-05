@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-light question-card">
                <div class="card-header bg-light"></div>

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
                    @svg('heart')
                </div>
                <div class="card-footer bg-light">@svg('heart')</div>
            </div>
        </div>
    </div>
</div>
@endsection
