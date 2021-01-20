@extends('layouts.app')

@section('content')

@if ($message = Session::get('success'))
<div class="custom-alerts alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    {!! $message !!}
</div>


<form action="{{route('orders.store')}}" method="POST" name="form">
    @csrf
    <input type="hidden" name="user_id" value="{{Auth::id()}}">
</form>


<script>
    window.onload=function(){
        window.setTimeout(document.form.submit.bind(document.form), 1000);
    };
</script>
<?php Session::forget('success');?>
@endif
@if ($message = Session::get('error'))
<div class="custom-alerts alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    {!! $message !!}
</div>
@endif
<div class="text-center d-flex flex-column align-items-center justify-content-center" style="height:30vh">
    <h1>Thank You For Your Order</h1>
    {{-- <p>A confirmation email was sent</p><a class="btn btn-light" role="button" href="/">Go Back To Home Page</a> --}}
</div>
@endsection