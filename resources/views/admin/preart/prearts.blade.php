@extends('layouts.panel')


@section('content')
<div class="container">
    @foreach($prearts as $preart)
    <?php $hasCategories = $preart->categories->pluck('id'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Arts to approve</div>

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


                        <form method="POST" action="{{ route('admin.approve.preart') }}" id="add-preart-form">
                            @csrf
                            <div class="form-group row">
                                <label for="art" class="col-sm-2 col-form-label">Art:</label>
                                <div class="col-sm-10">
                                    <input class="form-control enabled-disabled" name="title" disabled type="text" value="{{ $preart->title }}"/>
                                    <input type="hidden" name="art_id" value="{{ $preart->id }}">
                                    <input type="hidden" name="user_id" value="{{ $preart->user_id }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control enabled-disabled" name="description" disabled>{{ $preart->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="categories" class="col-sm-2 col-form-label">Categories:</label>
                                <div class="col-sm-10">
                                    <select class="form-control enabled-disabled" name="categories[]" multiple disabled>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" <?php echo $hasCategories->search($category->id) !== false ? 'Selected' : ''; ?>>{{ $category->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tags" class="col-sm-2 col-form-label">Tags:</label>
                                <div class="col-sm-10">
                                    <div class="selected-tags">
                                        <ul id="selected-tags-ul" class="selected-tags-ul list-group list-group-horizontal">
                                        @foreach($preart->tags as $tag)
                                            <li class="list-group-item list-group-item-primary selected-tags-li">{{ $tag->name }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                    <div class="tag-container">
                                        <input type="hidden" name="tags" id="hidden-tag-input" value="<?php $i=0; foreach($preart->tags as $tag){ $i++; if($i < count($preart->tags)){echo $tag->name . ', ';} else { echo $tag->name; }} ?>"/>
                                        <input class="form-control" id="tag-input" type="text" required/>
                                    </div>
                                    <ul id="tags" class="list-group">
                                </div>
                            </div>
                            <p>Options:</p>
                            <div class="row">
                                @foreach($preart->choices as $key => $choice)
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
                        {{ $prearts->links() }}
                    </div>
                </div>
            </div>
            <div class="block-button">
                <button id="add-preart" type="button" class="btn btn-primary btn-lg btn-block">Approve</button>
                <button id="edit-button" type="button" class="btn btn-success btn-lg btn-block">Edit</button>
                <div class="delete-preart-container">
                    <form method="POST" action="{{ route('admin.delete.preart', ['id' => $preart->id]) }}" id="delete-preart">
                        @csrf
                        {!! method_field('DELETE') !!}
                        <button id="delete-preart" type="submit" class="btn btn-danger btn-lg btn-block">Delete</button>
                    </form>
                </div>
            </div>
            

        </div>
    </div>
    @endforeach
</div>
@endsection
