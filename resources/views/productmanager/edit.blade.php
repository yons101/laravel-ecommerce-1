@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Edit a product</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary" href="{{ route('productmanager.index') }}"> Back</a>
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
<form action="{{ route('productmanager.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$product->title}}">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="3" name="description">{{$product->description}}</textarea>
    </div>

    <div class=" form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="{{$product->price}}">
    </div>

    <div class="form-group">
        <img src="{{$product->image}}" alt="" class="w-25 mb-5">
        <input type="file" class="form-control-file" id="image" name="image" value="{{$product->image}}">
    </div>

    <button class="btn btn-dark" type="submit">Update Product</button>


</form>
@endsection