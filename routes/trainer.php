<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainerDashboardController;
use App\Http\Controllers\TrainerBookingController;

Route::middleware(['auth', 'verified', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');
    
    // Booking Management
    Route::get('/bookings', [TrainerBookingController::class, 'index'])->name('bookings');
    Route::post('/bookings/{booking}/approve', [TrainerBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/decline', [TrainerBookingController::class, 'decline'])->name('bookings.decline');
    
    // Client Management
    Route::get('/clients', [TrainerDashboardController::class, 'clients'])->name('clients');
    
    // Reviews
    Route::get('/reviews', [TrainerDashboardController::class, 'reviews'])->name('reviews');
    
    // Earnings
    Route::get('/earnings', [TrainerDashboardController::class, 'earnings'])->name('earnings');
    
    // Performance Analytics
    Route::get('/performance', [TrainerDashboardController::class, 'performance'])->name('performance');
    
});
