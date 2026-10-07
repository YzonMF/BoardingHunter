<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Every signed-in user can view and edit their own profile and password.
 * The role itself can only be changed by an admin.
 */
class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $details = match ($user->role) {
            'roomOwner' => $user->owner,
            'roomSeeker' => $user->seeker,
            default => null,
        };

        return view('profiles.showprofile', compact('user', 'details'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'fullname' => 'required|string|max:50',
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')->ignore($user->UserID, 'UserID')],
            'contactnum' => 'required|string|max:50',
            'BusinessName' => 'nullable|string|max:100',
            'Preferences' => 'nullable|string|max:100',
        ]);

        $user->update(collect($data)->only(['fullname', 'email', 'contactnum'])->all());

        if ($user->role === 'roomOwner' && $user->owner) {
            $user->owner->update(['BusinessName' => $data['BusinessName'] ?? null]);
        } elseif ($user->role === 'roomSeeker' && $user->seeker) {
            $user->seeker->update(['Preferences' => $data['Preferences'] ?? null]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ]);

        Auth::user()->update(['password' => Hash::make($request->input('password'))]);

        return redirect()->route('profile.show')->with('success', 'Password changed.');
    }
}
