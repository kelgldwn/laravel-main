<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
        return ['mail']; // Only mail
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Booking ' . ucfirst($this->booking->status))
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your booking with ' . $this->booking->trainer->name . ' has been ' . $this->booking->status . '.')
            ->line('Date: ' . $this->booking->booking_date)
            ->line('Time: ' . $this->booking->booking_time)
            ->action('View Booking', url('/dashboard')) // You can customize this URL
            ->line('Thank you for using our platform.');
    }
}
