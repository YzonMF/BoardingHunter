<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\Seeker;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a list of all users.
     */
    public function index()
    {
        $users = User::with(['admin', 'owner', 'seeker'])
                    ->orderBy('dateJoined', 'desc')
                    ->paginate(10);
        
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['admin', 'owner', 'seeker']);
        return view('users.show', compact('user'));
    }
}