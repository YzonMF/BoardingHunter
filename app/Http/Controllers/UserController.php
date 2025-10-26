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
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::with(['admin', 'owner', 'seeker'])
                    ->orderBy('dateJoined', 'desc')
                    ->paginate(10);
        
        return view('users.index', compact('users'));
    }
    
    public function show(User $users)
    {
        $users->load(['admin', 'owner', 'seeker']);
        return view('users.show', compact('user'));
    }


}