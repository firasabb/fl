@extends('layouts.panel')


@section('content')
<div class="container">
    @foreach($prequestions as $prequestion)
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


                        <form method="POST" action="{{ route('admin.approve.prequestion') }}" id="add-prequestion-form">
                            @csrf
                            <div class="form-group row">
                                <label for="question" class="col-sm-2 col-form-label">Question:</label>
                                <div class="col-sm-10">
                                    <input class="form-control enabled-disabled" name="title" disabled type="text" value="{{ $prequestion->title }}"/>
                                    <input type="hidden" name="question_id" value="{{ $prequestion->id }}">
                                    <input type="hidden" name="user_id" value="{{ $prequestion->user_id }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control enabled-disabled" name="description" disabled>{{ $prequestion->description }}</textarea>
                                </div>
                            </div>
                            <p>Options:</p>
                            <div class="row">
                                @foreach($prequestion->choices as $key => $choice)
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <input class="form-control enabled-disabled" name="options[{{ $key }}]" type="text" disabled value="{{ $choice->choice }}" />
                                        </div>
                                    </div>
                                    
                                @endforeach
                            </div>

                        </form>

                    
                    <div class="pagination-container">
                        {{ $prequestions->links() }}
                    </div>
                </div>
            </div>
            <div class="block-button">
                <button id="add-prequestion" type="button" class="btn btn-primary btn-lg btn-block">Approve</button>
                <button id="edit-button" type="button" class="btn btn-success btn-lg btn-block">Edit</button>
                <div class="delete-prequestion-container">
                    <form method="POST" action="{{ route('admin.delete.prequestion', ['id' => $prequestion->id]) }}" id="delete-prequestion">
                        @csrf
                        {!! method_field('DELETE') !!}
                        <button id="delete-prequestion" type="submit" class="btn btn-danger btn-lg btn-block">Delete</button>
                    </form>
                </div>
            </div>
            

        </div>
    </div>
    @endforeach
</div>
@endsection
