@extends('layouts.app')


@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped w-75 mx-auto">

                <thead>
                    <th>N</th>
                    <th>Order ID </th>
                    <th>Order Total</th>
                    <th>Shipped? 🚚</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($orders as $order)

                        <tr>
                            <td class="align-middle">{{ ++$i }}</td>
                            <td class="align-middle ">{{ $order->id }}</td>
                            <td class="align-middle">{{ $order->price }} DH</td>
                            <td class="align-middle">{{ $order->is_shipped ? 'Yes' : 'No ' }}</td>

                            <td class="align-middle w-25">
                                <a class=" btn btn-dark text-white" href="{{ route('orders.show', $order->id) }}">
                                    Order Details
                                </a>
                            </td>
                        </tr>
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
