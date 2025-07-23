<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class BookingStatusUpdated extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database']; // You can add 'mail' if you want email as well
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your booking with ' . $this->booking->trainer->name . ' was ' . $this->booking->status . '.',
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
        ];
    }
}

