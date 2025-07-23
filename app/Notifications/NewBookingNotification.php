<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewBookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Line 29 is probably here:
        return [
            'message' => 'New booking request from ' . ($this->booking->client->name ?? 'Unknown') . '.',
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
        ];
    }
}
