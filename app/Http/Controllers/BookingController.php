<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $trainers = User::role('trainer')->get();
        return view('bookings.index', compact('trainers'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        Booking::create([
            'trainer_id' => $request->trainer_id,
            'client_id' => Auth::id(),
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Booking request sent!');
    }
}

