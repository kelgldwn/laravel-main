<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class PublicRegistrationController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:client,trainer'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto-verify for now
        ]);

        // Assign role using Spatie Laravel Permission
        $user->assignRole($request->role);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        return match ($request->role) {
            'trainer' => redirect()->route('trainer.dashboard')->with('success', 'Welcome to TrainerBook! Your trainer account has been created.'),
            'client' => redirect()->route('dashboard')->with('success', 'Welcome to TrainerBook! Your client account has been created.'),
            default => redirect()->route('dashboard'),
        };
    }
}
