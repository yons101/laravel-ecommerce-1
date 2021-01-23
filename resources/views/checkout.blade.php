@extends('layouts.app')


@section('script')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/stripe.css') }}">@endsection
@section('content')

<h2 class="ml-1"><i class="far fa-credit-card"></i>&nbsp;Checkout</h2>

@if ($message = Session::get('success'))
<div class="custom-alerts alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    {!! $message !!}
</div>
<?php Session::forget('success');?>
@endif
@if ($message = Session::get('error'))
<div class="custom-alerts alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    {!! $message !!}
</div>
<?php Session::forget('error');?>
@endif

<div class="row mt-5">



    <div class="col-12 col-md-6 payment">
        <div class="card credit-card-box mx-3">
            <div class="card-header">
                <h3 class="d-flex justify-content-between align-items-center"><span class="panel-title-text">Payment
                        Details </span><img class="img-fluid panel-title-image w-50"
                        src="assets/img/payment-methods.png"></h3>
            </div>
            <div class="card-body border rounded">

                <form action="{{route('checkout.store')}}" method="post" id="payment-form">
                    {{-- onsubmit="event.preventDefault();" --}}
                    @csrf


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="name">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" required value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="address">Full Address</label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                name="address" required value="{{ old('address') }}">
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="city">City</label>
                            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                name="city" required value="{{ old('city') }}">
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="province">Province</label>
                            <input id="province" type="text"
                                class="form-control @error('province') is-invalid @enderror" name="province" required
                                value="{{ old('province') }}">
                            @error('province')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="zip">Postal Code</label>
                            <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror"
                                name="zip" required value="{{ old('zip') }}">
                            @error('zip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="phone">Phone</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" required value="{{ old('phone') }}">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="country">Country</label>

                            @include('inc.country-list')

                            @error('country')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="card_no" type="text" class="form-control @error('card_no') is-invalid @enderror"
                                name="card_no" value="{{ old('card_no') }}" required autocomplete="card_no"
                                placeholder="Card No." autofocus>
                            @error('card_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="exp_month" type="text"
                                class="form-control @error('exp_month') is-invalid @enderror" name="exp_month"
                                value="{{ old('exp_month') }}" required autocomplete="exp_month"
                                placeholder="Exp. Month (Eg. 02)" autofocus>
                            @error('exp_month')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input id="exp_year" type="text"
                                class="form-control @error('exp_year') is-invalid @enderror" name="exp_year"
                                value="{{ old('exp_year') }}" required autocomplete="exp_year"
                                placeholder="Exp. Year (Eg. 2020)" autofocus>
                            @error('exp_year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="cvv" type="password" class="form-control @error('cvv') is-invalid @enderror"
                                name="cvv" required value="{{ old('username') }}" placeholder="CVV">
                            @error('cvv')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="amount" type="hidden" class="form-control @error('amount') is-invalid @enderror"
                                name="amount" required placeholder="Amount" value="{{$info[0]->totalPrice}}">
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button class="btn btn-dark mt-2">Submit Payment</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <h3>Your Cart</h3>
        @if(isset($products) && $products->isNotEmpty())

        <table class="table table-striped table-responsive-md">
            <thead>
                <tr>
                    <th scope="col">img</th>
                    <th scope="col">title</th>
                    <th scope="col">qty</th>
                    <th scope="col">price</th>
                </tr>
            </thead>
            <tbody>
                {{-- Products that have the same id, used for quantiy--}}
                @foreach($products as $item)


                @if ($item->id != $lastId)

                <tr>
                    @php
                    $lastId = $item->id;
                    @endphp

                    <td class="align-middle">
                        <a href="{{route('products.show', $item->slug)}}" class="text-dark">
                            <img src="{{$item->image}}" alt="" style="width:4rem;">
                        </a>
                    </td>

                    <td class="align-middle">
                        <a href="{{route('products.show', $item->slug)}}" class="text-dark">
                            {{$item->title}}
                        </a>
                    </td>

                    <td class="align-middle">
                        <span>{{$item->quantity}}</span>
                    </td>

                    <td class="align-middle">{{$item->price}} DH</td>

                </tr>
                @endif


                @endforeach
                <tr>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td colspan="2" class=""><b class="h2">Total : {{$info[0]->totalPrice}} DH</b></td>
                    <td colspan="2" class="">
                        <form action="{{route('cart.index')}}" method="get">
                            @csrf
                            <button class="btn btn-light border p-1" type="submit">Edit the cart</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        <h1>No products</h1>
        @endif
    </div>
</div>
@endsection

@section('script2')
<script src="{{ asset('assets/js/stripe.js') }}"></script>
@endsection