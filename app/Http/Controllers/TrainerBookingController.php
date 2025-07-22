<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerBookingController extends Controller
{
    public function index()
    {
        // Get all bookings where the logged-in user is the trainer
        $bookings = Auth::user()->trainerBookings()->with('client')->get();

        return view('trainer.bookings', compact('bookings'));
    }
}
