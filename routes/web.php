<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TrainerRegistrationController;
use App\Http\Controllers\PublicRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\BookingController;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Custom Authentication Routes - MUST BE FIRST
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user is trying to access admin and has admin role
            if ($request->has('admin_login') && $user->hasAnyRole(['admin', 'super-admin'])) {
                return redirect('/admin');
            }

            return match (true) {
                $user->hasRole('trainer') => redirect('/trainer/dashboard'),
                $user->hasRole('client') => redirect('/dashboard'),
                default => redirect('/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    })->name('login.submit');

    Route::post('/register', [PublicRegistrationController::class, 'register'])->name('register.submit');
});

// Logout route - handles both regular and admin logout
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // If coming from admin, redirect to admin login
    if ($request->has('admin') || str_contains($request->headers->get('referer', ''), '/admin')) {
        return redirect('/admin/login');
    }
    
    return redirect('/');
})->name('logout');

// Dashboard routes
Route::view('dashboard', 'dashboard')
    ->middleware(['auth:web', 'verified'])
    ->name('dashboard');

Route::middleware(['auth:web'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Existing trainer dashboard route
Route::middleware(['auth:web', 'verified', 'role:trainer'])->group(function () {
    Route::get('/trainer/dashboard', function () {
        return view('trainer.dashboard');
    })->name('trainer.dashboard');

    Route::get('/trainer/bookings', [\App\Http\Controllers\TrainerBookingController::class, 'index'])
        ->name('trainer.bookings');
    Route::post('/trainer/bookings/{booking}/approve', [\App\Http\Controllers\TrainerBookingController::class, 'approve'])
        ->name('trainer.bookings.approve');
    Route::post('/trainer/bookings/{booking}/decline', [\App\Http\Controllers\TrainerBookingController::class, 'decline'])
        ->name('trainer.bookings.decline');
});

// Booking Routes for Clients
Route::middleware(['auth:web', 'role:client'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    Route::get('/client/bookings', [\App\Http\Controllers\ClientBookingController::class, 'history'])
        ->name('client.bookings.history');
});

Route::post('/notifications/{id}/read', function ($id) {
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return back();
})->name('notifications.markAsRead');

Route::post('/available-trainers', [BookingController::class, 'getAvailableTrainers'])->name('available.trainers');
