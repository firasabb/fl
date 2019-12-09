@extends('layouts.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center search-row">
        <div class="col-md-12 search-col">
            <form method="post" action="{{ route('admin.search.questions') }}">
                {!! csrf_field() !!}
                <div class="form-row" >
                    <div class="col">
                        <input type='number' name="id" placeholder="ID..." class="form-control"/>
                    </div>
                    <div class="col">
                        <input type='text' name="name" placeholder="Tag Name..." class="form-control"/>
                    </div>
                    <div class="col-sm-1">
                        <input type='submit' value="Search" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Questions</div>

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

                    <table class="table">
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Title
                            </th>
                            <th>
                                URL
                            </th>
                            <th>
                                Answers
                            </th>
                            <th class="td-actions">
                                Actions
                            </th>   
                        </tr>
                        @foreach ($questions as $question)
                            <tr>
                                <td>
                                    {{$question->id}}
                                </td>
                                <td>
                                    {{ $question->title }}
                                </td>
                                <td>
                                    <a href="{{ route('show.question', ['url' => $question->url]) }}">{{ $question->url }}</a>
                                </td>
                                <td>
                                    {{ $question->answers()->count() }}
                                </td>
                                <td>
                                    <div class="td-actions-btns">
                                        <a href="{{ route('admin.show.question', ['id' => $question->id]) }}" class="btn btn-success">Show/Edit</a>
                                        <form action="{{ route('admin.delete.question', ['id' => $question->id]) }}" method="POST" id="delete-form-tags" class="delete-form-1">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $questions->links() }}
                </div>
            </div>
            <div class="block-button">
                <a href="{{route('create.prequestion')}}" target="_blank" class="btn btn-primary btn-lg btn-block">Add Question</a>
            </div>

        </div>
    </div>
</div>
@endsection
