@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>Add a new category</h2>
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
<form action="{{ route('productmanager.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
    </div>

    <button class="btn btn-dark" type="submit">Create Category</button>


</form>
@endsection