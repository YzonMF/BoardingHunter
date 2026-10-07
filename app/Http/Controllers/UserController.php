<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user (admin-side).
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'contactnum' => 'required|string|max:50',
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
        ]);

        $user = new User;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->contactnum = $request->contactnum;
        $user->role = $request->role;
        $user->save();

        return redirect('/users')->with('success', 'User created successfully.');
    }

    /**
     * Handle public registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users',
            'contactnum' => 'required|string|max:50',
            'role' => ['required', Rule::in(User::PUBLIC_ROLES)],
            'password' => 'required|min:8|confirmed'
        ]);

        $user = new User;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->contactnum = $request->contactnum;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/dashboard');
                case 'roomOwner':
                    return redirect()->intended('/boardinghunter/home');
                case 'roomSeeker':
                    return redirect()->intended('/boardinghunter/home');
                default:
                    return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->UserID . ',UserID',
            'contactnum' => 'required|string|max:50',
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->contactnum = $request->contactnum;
        $user->role = $request->role;

        // Only update password if a new one was provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/users')->with('success', 'User updated successfully.');
    }

    /**
     * Delete the specified user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/users')->with('success', 'User deleted successfully.');
    }
}
