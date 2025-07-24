<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBookingNotification;
use App\Notifications\BookingStatusUpdated;


class TrainerBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // optional filter

        $bookings = Booking::where('trainer_id', Auth::id())
            ->when($status, fn($query) => $query->where('status', $status))
            ->with('client') // eager-load client info
            ->latest()
            ->get();

        return view('trainer.bookings', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        $this->authorizeTrainer($booking);
        $booking->update(['status' => 'approved']);

        // Notify the client
        $booking->load('client', 'trainer'); // ensure relationships are loaded
        $booking->client->notify(new BookingStatusUpdated($booking));
    
        return back()->with('success', 'Booking approved.');
    }
    
    public function decline(Booking $booking)
    {
        $this->authorizeTrainer($booking);
        $booking->update(['status' => 'declined']);

        // Notify the client
        $booking->load('client', 'trainer');
        $booking->client->notify(new BookingStatusUpdated($booking));
    
        return back()->with('success', 'Booking declined.');
    }
    
    private function authorizeTrainer($booking)
    {
        abort_if($booking->trainer_id !== auth()->id(), 403, 'Unauthorized action.');
    }
    
}

