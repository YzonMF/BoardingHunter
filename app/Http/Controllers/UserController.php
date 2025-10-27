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
        $users = User::with(['admin', 'owner', 'seeker'])
                    ->orderBy('dateJoined', 'desc')
                    ->paginate(10);
        
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
public function show($userId)
{
        // Find user by primary key with related data
        $user = User::with(['admin', 'owner', 'seeker'])->findOrFail($userId);
        return view('users.show', compact('user'));

}
}