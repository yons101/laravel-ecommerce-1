@extends('layouts/app')

@section('content')

{{-- {{ dd($products) }} --}}




<section id="carousel">
    <div class="carousel slide" data-ride="carousel" id="carousel-1">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active"><img class="w-100 d-block" src="assets/img/iphone11pro.png"
                    alt="Slide Image"></div>
            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/ipadpro.png" alt="Slide Image"></div>
            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/iphone11.png" alt="Slide Image"></div>
        </div>
        <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span
                    class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a
                class="carousel-control-next" href="#carousel-1" role="button" data-slide="next"><span
                    class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
        <ol class="carousel-indicators">
            <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-1" data-slide-to="1"></li>
            <li data-target="#carousel-1" data-slide-to="2"></li>
        </ol>
    </div>
    <div class="row">
        <div class="col"><a class="btn btn-link btn-block" role="button" data-bs-hover-animate="jello"
                href="#products"><i class="fas fa-chevron-down text-dark h2 my-5"></i></a>
        </div>
    </div>
</section>
<section id="products" class="mt-3">
    <h2 class="text-center mb-5">Check Our
        Products</h2>
    <div class="row mb-4">

        @foreach($products as $product)


        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <a class="text-decoration-none text-dark text-dark" href="/products/{{$product->slug}}">


                <div class="card shadow-sm text-center"><img class="card-img-top w-100 d-block product-img"
                        src="{{$product->image}}">

                    <div class="card-body d-flex justify-content-between align-items-center p-2">
                        <h4 class="card-title mb-0 text-capitalize">{{ Str::replaceArray('-', [' '], $product->title) }}

                        </h4>
                        <div><span class="badge badge-dark "><span
                                    class="mr-1">{{$product->price}}</span><span>DH</span></span>

                        </div>
                    </div>
                </div>
            </a>
        </div>

        @endforeach

    </div>

    <div class="text-center">
        <a class="btn btn-dark" href="{{route('products.index')}}">Find More Products</a>
    </div>

</section>



@endsection