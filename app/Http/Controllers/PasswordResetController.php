<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * "Forgot password" for signed-out users: email a reset link, then set a new password.
 */
class PasswordResetController extends Controller
{
    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendLink(Request $request)
    {
        $request->validate(['email' => 'required|email|max:50']);

        try {
            Password::sendResetLink($request->only('email'));
        } catch (\Throwable $e) {
            // Mail may be misconfigured; do not reveal that (or whether the account exists).
            Log::error('Password reset email failed: ' . $e->getMessage());
        }

        // Same answer whether or not the address is registered, so accounts cannot be probed.
        return back()->with('success', 'If that email is registered, a password reset link has been sent.');
    }

    public function showReset(Request $request, string $token)
    {
        return view('auth.reset', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Your password has been reset. Please log in.');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => 'This password reset link is invalid or has expired. Please request a new one.']);
    }
}
