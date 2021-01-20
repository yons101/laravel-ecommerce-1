<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::latest()->paginate(5);

        return view('usermanager.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return view('usermanager.show', compact('user'));
    }


    public function edit($id)
    {

        $user = User::where('id', $id)->firstOrFail();

        return view('usermanager.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {

        $user = User::where('id', $id)->firstOrFail();

        $user->username = $request->username;
        $user->password = $request->password;

        $user->profile->fullname = $request->fullname;
        $user->profile->phone = $request->phone;
        $user->profile->address = $request->address;

        $user->save();
        $user->profile->save();

        return redirect()->route('usermanager.index')->with('success', 'Your Profile Has Been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $user->delete();
        return redirect()->route('usermanager.index')
            ->with('success', 'User has been deleted successfully.');
    }
}
