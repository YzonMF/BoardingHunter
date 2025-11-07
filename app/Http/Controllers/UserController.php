<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::all();
        
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
public function show(User $user)
{
        return view('users.show', compact('user'));
}

// create
public function create(){
    return view('users.create');
}

public function store(){
   $users  = new User;
   $users ->fullname = request()->fullname;
   $users ->email = request()->email;
   $users ->contactnum = request()->contactnum;
   $users ->role = request()->role;
   $users->save();

    return redirect('/users');
}

// edit
public function edit(User $user)
{
        return view('users.edit', compact('user'));
}
public function update(User $user){
   $user ->fullname = request()->fullname;
   $user ->email = request()->email;
   $user ->contactnum = request()->contactnum;
   $user ->role = request()->role;
   $user->save();

    return redirect('/users');
}

// delete
public function destroy(User $user){
    $user->delete();
    return redirect('/users');
}

}
