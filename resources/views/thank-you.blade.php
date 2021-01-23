@extends('layouts.app')
@section('content')

    @if ($message = Session::get('success'))
        <div class="custom-alerts alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
        </div>

        <form action="{{ route('orders.store') }}" method="POST" name="form">
            @csrf
            <input type="hidden" name="name" value="{{ Session::get('data')['name'] }}">
            <input type="hidden" name="address" value="{{ Session::get('data')['address'] }}">
            <input type="hidden" name="city" value="{{ Session::get('data')['city'] }}">
            <input type="hidden" name="zip" value="{{ Session::get('data')['zip'] }}">
            <input type="hidden" name="province" value="{{ Session::get('data')['province'] }}">
            <input type="hidden" name="phone" value="{{ Session::get('data')['phone'] }}">
            <input type="hidden" name="country" value="{{ Session::get('data')['country'] }}">
        </form>


        <script>
            window.onload = function() {
                window.setTimeout(document.form.submit.bind(document.form), 1000);
            };

        </script>
        <?php Session::forget('success'); ?>
    @endif
    @if ($message = Session::get('error'))
        <div class="custom-alerts alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
        </div>
    @endif
    <div class="text-center d-flex flex-column align-items-center justify-content-center" style="height:30vh">
        <h1>Thank You For Your Order</h1>
    </div>
@endsection
