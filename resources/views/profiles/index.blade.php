@extends('layouts.app')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <form action="{{ route('profile.edit', $user->id) }}" method="GET">
            <table class="table table-striped w-75 mx-auto">

                <tbody>
                    @csrf
                    <tr>
                        <td>Full Name</td>
                        <td class="text-right">{{ $profile->fullname }}</td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td class="text-right">{{ $user->username }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Email</td>
                        <td>{{ $user->email }}</td>
                    </tr> --}}
                    <tr>
                        <td>Password</td>
                        <td class="text-right">XXXXXXX</td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td class="text-right">{{ $profile->phone }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td class="text-right">{{ $profile->address }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><button class="btn btn-dark w-50 mx-auto d-block" type="submit">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <input type="hidden" name="fullname" value="">
            <input type="hidden" name="username" value="">
            <input type="hidden" name="password" value="">
            <input type="hidden" name="phone" value="">
            <input type="hidden" name="address" value="">
        </form>
    </div>
@endsection
