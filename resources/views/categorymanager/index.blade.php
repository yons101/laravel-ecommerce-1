@extends('layouts.app')

@section('content')

    <div class="row mb-2">
        <div class="col-lg-12 margin-tb">
            <div class="float-right">
                <a class="btn btn-primary" href="{{ route('categorymanager.create') }}">Create a new category</a>
            </div>
        </div>
    </div>
    @if ($categories->isNotEmpty())
        <table class="table table-striped table-bordered">
            <tr class="align-middle text-center">
                <th>Title</th>
                <th>Action</th>
            </tr>
            @foreach ($categories as $category)
                <tr>
                    <td class="align-middle text-center ">{{ $category->title }}</td>
                    <td class="align-middle text-center w-50">
                        <form action="{{ route('categorymanager.destroy', $category->id) }}" method="POST">

                            <div class="row">
                                <div class="col-lg-4">
                                    <a class="btn btn-dark mb-1"
                                        href="{{ route('categorymanager.edit', $category->id) }}">Edit</a>
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-danger m-0">Delete</button>
                                </div>
                            </div>



                            @csrf
                            @method('DELETE')

                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $categories->links() !!}
    @else
        <h1 class="text-centerh">No categories</h1>
    @endif

@endsection
