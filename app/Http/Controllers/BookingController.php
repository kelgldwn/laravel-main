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
        'booking_date' => 'required|date|after_or_equal:today',
        'booking_time' => 'required',
    ], [
        'booking_date.after_or_equal' => 'You cannot book a session in the past.',
    ]);

    $existingBooking = Booking::where('client_id', Auth::id())
    ->where('trainer_id', $request->trainer_id)
    ->where('booking_date', $request->booking_date)
    ->whereIn('status', ['pending', 'approved']) // 🚫 still active bookings
    ->first();

    if ($existingBooking) {
        return redirect()->back()->withErrors([
            'duplicate' => 'You already have a booking with this trainer at the selected time.',
        ]);
    }

    $booking = Booking::create([
        'trainer_id' => $request->trainer_id,
        'client_id' => Auth::id(),
        'booking_date' => $request->booking_date,
        'booking_time' => $request->booking_time,
        'status' => 'pending',
    ]);

    $booking->load('trainer');

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

public function dashboard()
{
    $userId = Auth::id();

    $totalBookings = Booking::where('client_id', $userId)->count();

    $bookingsThisMonth = Booking::where('client_id', $userId)
        ->whereMonth('booking_date', now()->month)
        ->whereYear('booking_date', now()->year)
        ->count();

    // Assuming each booking is 1 hour; customize if you store duration
    $totalHours = Booking::where('client_id', $userId)->count();

    return view('dashboard', compact(
        'totalBookings',
        'bookingsThisMonth',
        'totalHours'
    ));
}

public function index()
{
    $bookings = Booking::where('client_id', auth()->id())->latest()->get();
    $trainers = User::where('role', 'trainer')->get(); // assuming you use a 'role' column

    return view('bookings.index', compact('bookings', 'trainers'));
}

}

