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

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        // Basic validation for all users
        $validated = $request->validate([
            'fullname' => 'required|string|max:50',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|min:6',
            'contactnum' => 'required|string|max:50',
            'Role' => 'required|in:roomSeeker,roomOwner'
        ]);

        try {
            // Create the main user
            $user = User::create([
                'fullname' => $validated['fullname'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'contactnum' => $validated['contactnum'],
                'Role' => $validated['Role']
            ]);

            // Create role-specific record based on the selected role
            if ($validated['Role'] === 'roomOwner') {
                $request->validate([
                    'BusinessName' => 'required|string|max:100'
                ]);
                
                Owner::create([
                    'UserID' => $user->UserID,
                    'BusinessName' => $request->BusinessName
                ]);
            } elseif ($validated['Role'] === 'roomSeeker') {
                $request->validate([
                    'Preferences' => 'nullable|string|max:100'
                ]);
                
                Seeker::create([
                    'UserID' => $user->UserID,
                    'Preferences' => $request->Preferences
                ]);
            }

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['admin', 'owner', 'seeker']);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the user.
     */
    public function edit(User $user)
    {
        $user->load(['owner', 'seeker']);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $user->UserID . ',UserID',
            'contactnum' => 'required|string|max:50',
        ]);

        try {
            $user->update($validated);

            // Update role-specific data
            if ($user->Role === 'roomOwner') {
                $request->validate([
                    'BusinessName' => 'required|string|max:100'
                ]);
                
                $user->owner()->updateOrCreate(
                    ['UserID' => $user->UserID],
                    ['BusinessName' => $request->BusinessName]
                );
            } elseif ($user->Role === 'roomSeeker') {
                $request->validate([
                    'Preferences' => 'nullable|string|max:100'
                ]);
                
                $user->seeker()->updateOrCreate(
                    ['UserID' => $user->UserID],
                    ['Preferences' => $request->Preferences]
                );
            }

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}