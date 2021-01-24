<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //route GET /profile
    public function index()
    {
        //jib luser li mconecte
        $user = Auth::user();

        //afficher lview li kayna fi /resources/views/profiles/index.blade.php 
        //osift lya m3aha les variables 'user'
        return view('profiles.index', compact('user'));
    }

    //route POST /profile/{id}
    public function update(Request $request, $id)
    {
        //jib luser li mconecte
        $user = Auth::user();

        //update les anciens valeurs par les derniers valeurs 
        //li msiftyin f $request
        $user->username = $request->username;
        $user->password = $request->password;
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;

        //appliquer les modifications
        $user->save();


        //redirect la route 'GET /profile', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('profile.index')->with('success', 'Your Profile Has Been Updated Successfully');
    }
}
