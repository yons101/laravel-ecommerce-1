@extends('layouts.app')

@section('content')

<div class="row mb-2">
    <div class="col-lg-12 margin-tb">
        <div class="float-right">
            <a class="btn btn-primary" href="{{ route('productmanager.create') }}">Create a new product</a>
        </div>
    </div>
</div>
@if ($products->isNotEmpty())
<table class="table table-striped table-bordered">
    <tr class="align-middle text-center">
        <th>Image</th>
        <th>Title</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td class="align-middle text-center w-25"><img src="{{$product->image}}" class="w-25"></td>
        <td class="align-middle text-center ">{{ $product->title }}</td>
        <td class="align-middle text-center ">{{ $product->price }} DH</td>
        <td class="align-middle text-center w-50">
            <form action="{{ route('productmanager.destroy',$product->id) }}" method="POST">

                <div class="row">
                    <div class="col-lg-4">
                        <a class="btn btn-dark mb-1" href="{{ route('products.show',$product->slug) }}">Show</a>
                    </div>
                    <div class="col-lg-4">
                        <a class="btn btn-dark mb-1" href="{{ route('productmanager.edit',$product->id) }}">Edit</a>
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-danger m-0">Delete</button>
                    </div>
                </div>



                @csrf
                @method('DELETE')

            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $products->links() !!}
@else
<h1 class="text-centerh">No products</h1>
@endif

@endsection