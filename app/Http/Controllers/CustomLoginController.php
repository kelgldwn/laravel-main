<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            return match (true) {
                $user->hasRole('trainer') => redirect('/trainer/dashboard'),
                $user->hasRole('client') => redirect('/dashboard'),
                default => redirect('/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
}
