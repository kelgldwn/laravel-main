<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Check if user has 2FA enabled
            if ($user->two_factor_secret) {
                // Log out the partially authenticated session
                Auth::logout();

                // Store the login ID in the session
                session(['login.id' => $user->getAuthIdentifier()]);

                // Redirect to the 2FA challenge route
                return redirect()->route('two-factor.login');
            }

            // Normal role-based redirects if no 2FA
            return match (true) {
                $user->hasRole('trainer') => redirect('/trainer/dashboard'),
                $user->hasRole('client') => redirect('/dashboard'),
                $user->hasRole('admin') => redirect('/admin/dashboard'),
                default => redirect('/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
}
