@extends('layouts.app')

@section('content')

    @if ($orders->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped w-75 mx-auto">

                <thead>
                    <th>Order ID </th>
                    <th>Buyer Name</th>
                    <th>Order Price</th>
                    <th>Shipped? 🚚</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($orders as $order)

                        <tr>
                            <td class="align-middle">{{ $order->id }}</td>
                            <td class="align-middle">{{ $order->user->fullname }}</td>

                            <td class="align-middle">{{ $order->products()->sum('price') }} DH</td>
                            <td class="align-middle">
                                {{ $order->shipping->is_shipped ? 'Yes' : 'No ' }}
                            </td>

                            <td class="align-middle w-25">
                                <a class=" btn btn-dark text-white" href="{{ route('ordermanager.show', $order->id) }}">
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
