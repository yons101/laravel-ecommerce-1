@extends('layouts.app')

@section('content')


@if ($users->isNotEmpty())
<table class="table table-striped table-bordered">
    <tr class="align-middle text-center">
        <th>Username</th>
        <th>Orders</th>
        <th>Action</th>
    </tr>
    @foreach ($users as $user)
    <tr>
        <td class="align-middle text-center w-25">{{$user->username}}</td>
        <td class="align-middle text-center ">{{ $user->orders->count() }}</td>
        <td class="align-middle text-center w-50">
            <form action="{{ route('usermanager.destroy',$user->id) }}" method="POST">

                <div class="row">
                    <div class="col-lg-4">
                        <a class="btn btn-dark mb-1" href="{{ route('usermanager.show',$user->id) }}">Show</a>
                    </div>
                    <div class="col-lg-4">
                        <a class="btn btn-dark mb-1" href="{{ route('usermanager.edit',$user->id) }}">Edit</a>
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

{!! $users->links() !!}
@else
<h1 class="text-centerh">No users</h1>
@endif

@endsection