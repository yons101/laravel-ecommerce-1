@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light ">
        <li class="breadcrumb-item "><a href="/" class="text-dark">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('products.index')}}" class="text-dark">Products</a></li>
        <li class="breadcrumb-item active text-capitalize " aria-current="page">
            {{ Str::replaceArray('-', [' '], $product->title) }}</li>
    </ol>
</nav>

<div class="row mt-5">
    <div class="col-12 col-md-6" id="product-col-1"><img class="w-75" src="{{$product->image}}"></div>

    <div class="col-12 col-md-6 d-flex flex-column justify-content-between" id="product-col-2">
        <div>
            <h2 id="product-title" class="text-capitalize">{{ Str::replaceArray('-', [' '], $product->title) }}</h2>



            <div id="product-price"><span class="badge badge-dark p-3"><span
                        class="mr-1">{{$product->price}}</span><span>DH</span></span>

            </div>
        </div>
        <p id="product-desc">{{$product->description}}<br><br><br></p>

        {{-- {{dd($product->id)}} --}}



        @if(Auth::user()!==null)
        <form
            action="{{ Auth::user()->role != "admin" ? route('cart.store') : route('productmanager.edit', $product->id)}}"
            method="{{ Auth::user()->role != "admin" ? 'POST' : 'GET'}}">
            @else
            <form action="{{route('cart.store')}}" method="POST">
                @endif

                @csrf
                <input type="hidden" name="id" id="id" value="{{$product->id}}">
                <input type="hidden" name="title" id="title" value="{{$product->title}}">
                <input type="hidden" name="price" id="price" value="{{$product->price}}">


                @if(Auth::user() == null or Auth::user()->role != "admin")
                <button class="btn btn-dark text-uppercase text-center d-lg-flex align-items-lg-start text-center"
                    data-bs-hover-animate="pulse" id="product-cto" type="submit">Add to Cart</button>
                @elseif(Auth::user()->role == "admin")
                <button class="btn btn-dark text-uppercase text-center d-lg-flex align-items-lg-start text-center"
                    data-bs-hover-animate="pulse" id="product-cto" type="submit">Edit Product</button>

                @endif
            </form>

    </div>
</div>
<h3 class="text-center my-5">You Might Also Like</h3>
<div class="row product-row">
    @foreach($products as $product)
    <div class="col-12 col-sm-6 col-md-3">
        <a class="text-decoration-none text-dark" href="{{$product->slug}}">

            <div class="card shadow-sm text-center"><img class="card-img-top w-100 d-block product-img"
                    src="{{$product->image}}">

                <div class="card-body d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 text-capitalize">{{ Str::replaceArray('-', [' '], $product->title) }}
                    </h4>
                    <div>
                        <span class="badge badge-dark">
                            {{$product->price}}
                            <span>DH</span>
                        </span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    @endforeach

</div>
@endsection