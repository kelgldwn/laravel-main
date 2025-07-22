<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TrainerRegistrationController;
use App\Http\Controllers\PublicRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\BookingController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';


Route::post('/login', [CustomLoginController::class, 'login'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
// Existing trainer dashboard route
Route::middleware(['auth', 'verified', 'role:trainer'])->group(function () {
    Route::get('/trainer/dashboard', function () {
        return view('trainer.dashboard');
    })->name('trainer.dashboard');
    // In routes/web.php inside the 'role:trainer' middleware group
Route::get('/trainer/bookings', [\App\Http\Controllers\TrainerBookingController::class, 'index'])->name('trainer.bookings');

});
// Booking Routes for Clients
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

//Route::get('/register-trainer', [TrainerRegistrationController::class, 'show'])->name('trainer.register');
//Route::post('/register-trainer', [TrainerRegistrationController::class, 'register'])->name('trainer.register.submit');

Route::get('/register', [PublicRegistrationController::class, 'show'])->name('register');
Route::post('/register', [PublicRegistrationController::class, 'register'])->name('register.submit');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        return match (true) {
            $user->hasRole('trainer') => redirect('/trainer/dashboard'),
            $user->hasRole('client') => redirect('/client/dashboard'),
            default => redirect('/dashboard'),
        };
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});


Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        return match (true) {
            $user->hasRole('trainer') => redirect('/trainer/dashboard'),
            $user->hasRole('client') => redirect('/client/dashboard'),
            default => redirect('/dashboard'),
        };
    }

    return back()->withErrors([
        'email' => 'These credentials do not match our records.',
    ]);
});


