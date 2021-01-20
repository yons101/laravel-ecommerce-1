@extends('layouts.app')


@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if ($orders->isNotEmpty())
<div class="table-responsive">
    <table class="table table-striped w-50 mx-auto">

        <thead>
            <th>N</th>
            <th>Order ID </th>
            <th>Order Price</th>
            <th>Shipped? 🚚</th>
            <th></th>
        </thead>

        <tbody>
            @foreach ($orders as $order)

            {{-- {{dd($order->products)}} --}}
            <tr>
                <td class="align-middle">{{++$i}}</td>
                <td class="align-middle">{{$order->id}}</td>

                <td class="align-middle">{{$order->products()->sum('price')}} DH</td>
                <td class="align-middle">{{$order->is_shipped ? 'Yes' : 'No '}}</td>

                <td class="align-middle w-25">
                    <a class=" btn btn-dark text-white" href="{{route('orders.show', $order->id)}}">
                        Order Details
                    </a>
                </td>
            </tr>
            @foreach ($order->products as $item)

            @endforeach
            @endforeach

        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $orders->links() !!}
    </div>

</div>
@else
<h1 class="text-center">No orders</h1>
@endif

@endsection