@extends('layouts.app')


@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped w-75 mx-auto">

            <thead>
                <th>N</th>
                <th>Order ID</th>
                <th>Product Image</th>
                <th>Product Title</th>
                <th>Product Price</th>
            </thead>

            <tbody>

                @foreach ($products as $item)

                    <tr>
                        <td class="align-middle">{{ ++$i }}</td>
                        <td class="align-middle">{{ $id }}</td>
                        <td class="align-middle w-25">
                            <a class="text-dark" href="{{ route('products.show', $item->slug) }}">
                                <img src="{{ $item->image }}" class="w-50">
                            </a>
                        </td>
                        <td class="align-middle w-25">
                            <a class="text-dark text-capitalize" href="{{ route('products.show', $item->slug) }}">
                                {{ Str::replaceArray('-', [' '], $item->title) }}
                            </a>
                        </td>
                        <td class="align-middle w-25">{{ $item->price }} DH</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
        <input type="hidden" name="fullname" value="">
        <input type="hidden" name="username" value="">
        <input type="hidden" name="password" value="">
        <input type="hidden" name="phone" value="">
        <input type="hidden" name="address" value="">
    </div>
@endsection
