@extends('layouts.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Questions to approve</div>

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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($prequestions as $prequestion)

                        <form method="POST" action="#">
                            <div class="form-group row">
                                <label for="question" class="col-sm-2 col-form-label">Question:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" disabled type="text" value="{{ $prequestion->title }}"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" disabled>{{ $prequestion->description }}</textarea>
                                </div>
                            </div>
                            <p>Options:</p>
                            <div class="row">
                                @foreach($prequestion->choices as $choice)
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <input class="form-control" type="text" disabled value="{{ $choice->choice }}" />
                                        </div>
                                    </div>
                                    
                                @endforeach
                            </div>

                        </form>

                    @endforeach
                    <div class="pagination-container">
                        {{ $prequestions->links() }}
                    </div>
                </div>
            </div>
            <div class="block-button">
                <button type="button" class="btn btn-primary btn-lg btn-block">Approve</button>
                <button type="button" class="btn btn-success btn-lg btn-block">Edit</button>
                <button type="button" class="btn btn-danger btn-lg btn-block">Delete</button>
            </div>
            

        </div>
    </div>
</div>
@endsection
