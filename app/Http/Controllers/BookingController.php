<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBookingNotification;
use App\Notifications\BookingStatusUpdated;

class BookingController extends Controller
{
    public function history()
{
        $bookings = Booking::with('trainer') // ✅ Fix here
        ->where('client_id', Auth::id())
        ->latest()
        ->get();

    return view('client.history', compact('bookings'));
}

    

    public function store(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $booking = Booking::create([
            'trainer_id' => $request->trainer_id,
            'client_id' => Auth::id(),
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending',
        ]);
        
        // Load trainer relationship
        $booking->load('trainer');
        
        // Now safe to use
        $booking->trainer->notify(new BookingStatusUpdated($booking));
        
        $trainer = User::find($request->trainer_id);
        if ($trainer) {
            $trainer->notify(new NewBookingNotification($booking));
        }

        return redirect()->back()->with('success', 'Booking request sent!');
    }
    public function getAvailableTrainers(Request $request)
{
    $date = $request->booking_date;
    $time = $request->booking_time;

    // Get IDs of trainers already booked at this slot
    $bookedTrainerIds = Booking::where('booking_date', $date)
        ->where('booking_time', $time)
        ->pluck('trainer_id');

    // Get trainers who are not booked
    $availableTrainers = User::role('trainer')
        ->whereNotIn('id', $bookedTrainerIds)
        ->get();

    return response()->json($availableTrainers);
}
}

