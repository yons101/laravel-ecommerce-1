@extends('layouts.app')

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif(session('success'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (10 == 0)
<div class="text-center d-flex flex-column align-items-center justify-content-center" style="height:30vh">
    <h1 class="text-capitalize">you have no item in your cart!</h1>
    <a class="btn btn-light" role="button" href="{{ route('index') }}">Go Back To Home Page</a>
</div>

@else

<h2 class="ml-1"><i class="far fa-credit-card"></i>&nbsp;Checkout</h2>
<div class="row mt-5">
    <div class="col-12 col-md-8">

        <h3>You have {{ $info[0]->quantity }} item(s) in your cart</h3>

        <div class="d-flex flex-column p-5">
            @if ($products->isNotEmpty())
            <table class="table table-striped table-responsive-md">
                <thead>
                    <tr>
                        <th scope="col">img</th>
                        <th scope="col">title</th>
                        <th scope="col">qty</th>
                        <th scope="col">price</th>
                        <th scope="col">delete</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Products that have the same id, used for
                                quantity--}}
                    @foreach ($products as $item)


                    @if ($item->id != $lastId)

                    <tr>
                        @php
                        $lastId = $item->id;
                        @endphp

                        <td class="align-middle">
                            <a href="{{ route('products.show', $item->slug) }}" class="text-dark">
                                <img src="{{ $item->image }}" alt="" style="width:4rem;">
                            </a>
                        </td>

                        <td class="align-middle">
                            <a href="{{ route('products.show', $item->slug) }}" class="text-dark">
                                {{ $item->title }}
                            </a>
                        </td>

                        <td class="align-middle">
                            <form action="{{ route('cart.update', $item->id) }}" method="post" class="d-inline-block m-0">
                                @csrf
                                @method('PUT')
                                <input class="" type="number" name="qty" value="{{ $item->quantity }}" style="width:3rem;" oninput="show({{$item->id }})">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button id="{{ 'confirm_' . $item->id }}" class="btn p-0 m-0" type="submit" style="display:none;">✔️</button>
                            </form>
                        </td>

                        <td class="align-middle">{{ $item->price }} DH</td>

                        <td class="align-middle">
                            <form class="m-0" action="{{ route('cart.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-dark" type="submit">X</button>
                            </form>
                        </td>

                    </tr>
                    @endif

                    @endforeach

                </tbody>
            </table>
            @else
            <h1>No products</h1>
            @endif
            <form action="{{ route('cart.empty') }}" method="post">
                @csrf
                <button class="btn btn-dark mt-5" type="submit">Empty the cart</button>
            </form>
        </div>
    </div>

    <div class="col-12 col-md-4 p-md-5">
        <div class="mt-5 d-flex justify-content-between h2">
            <span>Total</span>
            <div>
                <span class="mr-1">{{ $info[0]->totalPrice }}</span>
                <span>DH</span>
            </div>
        </div>

        <form action="{{ route('checkout.index') }}" method="get">
            @csrf
            <button class="btn btn-dark d-block w-100 mt-5 mx-auto" id="btn-checkout" type="submit">
                Check Out</button>
        </form>

    </div>
</div>
@endif


@endsection

<script>
    function show(id) {
        var x = document.getElementById("confirm_" + id);
        x.style.display = "inline-block";
    }
</script>