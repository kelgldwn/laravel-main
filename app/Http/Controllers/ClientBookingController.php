<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class ClientBookingController extends Controller
{
    public function history()
    {
        $bookings = Booking::with('trainer') // eager load trainer relationship
            ->where('client_id', Auth::id())
            ->latest()
            ->get();

        return view('client.history', compact('bookings'));
    }
}
