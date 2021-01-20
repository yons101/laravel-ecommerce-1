@extends('layouts.app')

@section('content')
<div class="table-responsive">
    <form action="{{route('profile.update', $user->id)}}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-striped w-50 mx-auto">

            <tbody>
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="fullname" value="{{ old('fullname') ?? $profile->fullname}}">
                    </td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" value="{{ old('username') ?? $user->username}}"></td>
                </tr>
                {{-- <tr>
                <td>Email</td>
                <td>{{$user->email}}</td>
                </tr> --}}
                <tr>
                    <td>Password</td>
                    <td><input type="text" name="password" value="{{ old('password') ?? $user->password}}"></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" name="phone" value="{{ old('phone') ?? $profile->phone}}"></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><input type="text" name="address" value="{{ old('address') ?? $profile->address}}"></td>
                </tr>
                <tr>
                    <td colspan=" 2"><button class="btn btn-dark w-50 mx-auto d-block" type="submit">Submit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection