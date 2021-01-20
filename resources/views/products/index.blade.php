@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light">
        <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>
        <li class="breadcrumb-item active">

            @if(isset($title))
            All Our {{$title}}'s
            @else
            All products
            @endif

            </a></li>
    </ol>
</nav>
<div class="row mt-5">

    <div class="col-md-3">
        <h3 class="mb-5">Sort By</h3>
        <div><span class=" h5"><i class="far fa-list-alt"></i>&nbsp;Category</span>
            <ul class="cat-list">
                <li><a href="{{route('category.show', 'iphone')}}" class="text-dark">iPhone</a></li>
                <li><a href="{{route('category.show', 'ipad')}}" class="text-dark">iPad</a></li>
                <li><a href="{{route('category.show', 'macbook')}}" class="text-dark">Macbook</a></li>

            </ul>
        </div>
        <div><span class="h5"><i class="fas fa-dollar-sign"></i>&nbsp;Price<br></span>
            <ul class="cat-list">
                <li><a href="{{route('price.show', ['0', '1000'])}}" class="text-dark">0-1000</a></li>
                <li><a href="{{url('/price/2001/3000')}}" class="text-dark">2001-3000</a></li>
                <li><a href="{{route('price.show', ['1001', '2000'])}}" class="text-dark">1001-2000</a></li>
                <li><a href="{{route('price.show', ['2001', '3000'])}}" class="text-dark">2001-3000</a></li>
                <li><a href="{{route('price.show', ['3001', '4000'])}}" class="text-dark">3001-4000</a></li>
                <li><a href="{{route('price.show', ['4001', '5000'])}}" class="text-dark">4001-5000</a></li>
                <li><a href="{{route('price.show', ['5001', '6000'])}}" class="text-dark">5001-6000</a></li>
                <li><a href="{{route('price.show', ['6001', '7000'])}}" class="text-dark">6001-7000</a></li>
                <li><a href="{{route('price.show', ['7001' , '8000'])}}" class="text-dark">7001-8000</a></li>
                <li><a href="{{route('price.show', ['8001' , '9000'])}}" class="text-dark">8001-9000</a></li>
                <li><a href="{{route('price.show', ['9001' , '10000'])}}" class="text-dark">9001-10000</a></li>


            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div>
            <h3 class="mb-4">
                @if(isset($title))

                All Our {{$title}}'s
                @else
                All products

                @endif

            </h3>




            <div class="row mb-2">

                @foreach($products as $product)
                <div class="col-12 col-sm-4 mb-4">
                    <a class="text-decoration-none text-dark" href="/products/{{$product->slug}}">

                        <div class="card shadow-sm text-center"><img class="card-img-top w-100 d-block product-img"
                                src="{{$product->image}}">

                            <div class="card-body d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0 text-capitalize">
                                    {{ Str::replaceArray('-', [' '], $product->title) }}</h4>

                                <div><span class="badge badge-dark"><span
                                            class="mr-1">{{$product->price}}</span><span>DH</span></span>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                @endforeach
            </div>

        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    {!! $products->links() !!}
</div>
@endsection