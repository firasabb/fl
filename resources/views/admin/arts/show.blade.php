@extends('layouts.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{ route('show.art', ['url' => $art->url]) }}">{{$art->title}}</a></div>

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

                    <div class="text-center p-3">
                        <h5>Asked by: <a href="{{ url('admin/dashboard/user/' . $art->user->id) }}">{{ $art->user->name }}</a></h5>
                    </div>

                    <form method="POST" action="{{ route('admin.edit.art', ['id' => $art->id]) }}" id="edit-form-arts">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="title">Art:</label>
                                    <input class="form-control enabled-disabled" type="text" name="title"  value="{{ $art->title }}" placeholder="Title" disabled/>
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <label for="url">URL:</label>
                                    <input class="form-control enabled-disabled" type="text" name="url"  value="{{ $art->url }}" placeholder="Url" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control enabled-disabled" name="description" disabled>{{ $art->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="categories">Categories:</label>
                                <select class="form-control enabled-disabled" name="categories[]" multiple disabled>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" <?php echo $hasCategories->search($category->id) !== false ? 'Selected' : ''; ?>>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row edit-tags">
                            <div class="col">
                                <label for="tags">Tags:</label>
                                <div class="selected-tags">
                                    <ul id="selected-tags-ul" class="selected-tags-ul list-group list-group-horizontal">
                                    @foreach($art->tags as $tag)
                                        <li class="list-group-item list-group-item-primary selected-tags-li">{{ $tag->name }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                                <div class="tag-container">
                                    <input type="hidden" name="tags" id="hidden-tag-input" value="<?php $i=0; foreach($art->tags as $tag){ $i++; if($i < count($art->tags)){echo $tag->name . ', ';} else { echo $tag->name; }} ?>"/>
                                    <input class="form-control enabled-disabled" id="tag-input" type="text" disabled/>
                                </div>
                                <ul id="tags" class="list-group">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col submit-btn-roles">
                                <button type="submit" class="btn btn-primary submit-edit-btn enabled-disabled" disabled>Submit</button>
                            </div>
                        </div>
                        <div class="row info-row">
                            <div class="col">
                                <h5>Created at:</h1>
                                <p>{{ $art->created_at }}</p>
                                <h5>Updated at:</h1>
                                <p>{{ $art->updated_at }}</p>
                            </div>
                            <div class="col">
                                <h5>ID:</h1>
                                <p>{{ $art->id }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="block-button">
                <button type="button" class="btn btn-success btn-lg btn-block" id="edit-button">Edit Art</button>
                <form action="{{ route('admin.delete.art', ['id' => $art->id]) }}" method="POST" id="delete-form-arts" class="delete-form-2">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <button type="submit" class="btn btn-danger btn-lg btn-block">Delete Art</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
