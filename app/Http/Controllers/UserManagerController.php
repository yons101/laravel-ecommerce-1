<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserManagerController extends Controller
{
    //page admin
    //route GET /usermanager
    public function index()
    {
        //jib les derniers 5 products
        $users = User::latest()->paginate(5);

        //afficher lview li kayna fi /resources/views/usermanager/index.blade.php 
        //osift lya m3aha les variables 'users'
        return view('usermanager.index', compact('users'));
    }

    //route GET /usermanager/{id}
    public function show($id)
    {
        //jib l user li ID = $id
        //sinon firstOrFail = 404
        $user = User::where('id', $id)->firstOrFail();

        //afficher lview li kayna fi /resources/views/usermanager/show.blade.php 
        //osift lya m3aha les variables 'user'
        return view('usermanager.show', compact('user'));
    }

    //route GET /usermanager/{id}

    public function edit($id)
    {
        //jib l user li ID = $id
        //sinon firstOrFail = 404
        $user = User::where('id', $id)->firstOrFail();

        //afficher lview li kayna fi /resources/views/usermanager/show.blade.php 
        //osift lya m3aha les variables 'user'
        return view('usermanager.edit', compact('user'));
    }

    //route PUT /usermanager/{id}
    public function update(Request $request, $id)
    {
        //jib l user li ID = $id
        //sinon firstOrFail = 404
        $user = User::where('id', $id)->firstOrFail();

        //update les anciens valeurs par les derniers valeurs 
        //li msiftyin f $request
        $user->username = $request->username;
        $user->password = $request->password;

        $user->fullname = $request->fullname;
        $user->phone = $request->phone;

        //appliquer les modifications
        $user->save();

        //redirect la route 'GET /usermanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('usermanager.index')->with('success', 'Your Profile Has Been Updated Successfully');
    }


    public function destroy($id)
    {
        //jib l User li ID = $id
        //sinon firstOrFail = 404
        $user = User::where('id', $id)->firstOrFail();

        //delete
        $user->delete();

        //redirect la route 'GET /usermanager', m3a wahd lmessage temporaire smito 'success'
        return redirect()->route('usermanager.index')
            ->with('success', 'User has been deleted successfully.');
    }
}
