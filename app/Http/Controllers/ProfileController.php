<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $profile = Auth::user()->profile;

        return view('profiles.index', compact(['user', 'profile']));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $profile = Auth::user()->profile;

        return view('profiles.edit', compact(['user', 'profile']));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $profile = Auth::user()->profile;

        $user->username = $request->username;
        $user->password = $request->password;

        $profile->fullname = $request->fullname;
        $profile->phone = $request->phone;
        $profile->address = $request->address;

        $user->save();
        $profile->save();

        return redirect()->route('profile.index')->with('success', 'Your Profile Has Been Updated Successfully');
    }
}
