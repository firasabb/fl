@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add a question</div>

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

                    <form method="POST" action="{{ route('create.prequestion') }}" class="needs-validation" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="questions-title">Question:</label>
                            <input class="form-control" type="text" name="title" placeholder="What is The Largest Galaxy in Our Universe?" value="{{ old('title') }}" required maxlength="200" minlength="15"/>
                            <div class="invalid-feedback">
                                    Please provide a valid question: maximum allowed number of characters is 300 and minimum number is 15.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question-description">Description:</label>
                            <textarea class="form-control" type="text" name="description" placeholder="Add a description to your question (Optional)..." maxlength="500">{{ old('description') }}</textarea>
                            <div class="invalid-feedback">
                                    Please provide a valid description: maximum allowed number of characters is 1000.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question-description">Categories:</label>
                            <select name="categories[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

                            <label for="question-description">Tags:</label>
                            <div class="tag-container">
                                <input class="form-control" id="tag-input" type="text" name="tags[]" value="{{ old('tags[]') }}" required/>
                            </div>
                        <div id="tags">
                        </div>
                        <div class="create-question-btns">
                            <button type="submit" class="btn btn-primary submit-question-btn">Submit</button>
                            <button type="button" class="btn btn-success add-choice-btn" id="add-option">Add an option</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
