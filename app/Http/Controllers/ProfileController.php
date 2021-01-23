<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        return view('profiles.edit', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();

        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $user->username = $request->username;
        $user->password = $request->password;

        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Your Profile Has Been Updated Successfully');
    }
}
