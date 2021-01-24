@extends('layouts.app')


@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('ordermanager.update', $order->id) }}" method="POST">
        <div class="table-responsive">
            <table class="table table-striped w-75 mx-auto">
                <tbody>
                    @csrf
                    @method('PUT')
                    <tr>
                        <td>Order ID</td>
                        <td class="text-right">{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td>Order Price</td>
                        <td class="text-right">{{ $order->products()->sum('price') }} DH</td>
                    </tr>

                    <tr>
                        <td>Shipped?</td>
                        <td class="text-right">
                            <select name='is_shipped' onchange='this.form.submit()'>

                                @if ($order->shipping->is_shipped)
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                @else
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                @endif

                            </select>
                            <noscript><input type="submit" value="Submit"></noscript>
                        </td>
                    </tr>
                    <tr>
                        <td>Buyers Name</td>
                        <td class="text-right">{{ $order->user->fullname }}</td>
                    </tr>
                    <tr>
                        <td>Buyer's Phone Number</td>
                        <td class="text-right">{{ $order->user->phone }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </form>
@endsection
