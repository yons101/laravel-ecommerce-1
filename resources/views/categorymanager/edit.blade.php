@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Edit a category</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary" href="{{ route('categorymanager.index') }}"> Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>There are some errors.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
</div>
@endif
<form action="{{ route('categorymanager.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$category->title}}">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="3" name="description">{{$category->description}}</textarea>
    </div>

    <div class=" form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="{{$category->price}}">
    </div>

    <div class="form-group">
        <img src="{{$category->image}}" alt="" class="w-25 mb-5">
        <input type="file" class="form-control-file" id="image" name="image" value="{{$category->image}}">
    </div>

    <button class="btn btn-dark" type="submit">Update category</button>


</form>
@endsection