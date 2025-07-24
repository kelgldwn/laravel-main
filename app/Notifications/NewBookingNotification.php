<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
        return ['mail']; // Only sending via mail
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Booking Request')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have a new booking request from ' . ($this->booking->client->name ?? 'a client') . '.')
            ->line('Date: ' . $this->booking->booking_date)
            ->line('Time: ' . $this->booking->booking_time)
            ->action('View Booking', url('/trainer/bookings')) // Adjust this URL as needed
            ->line('Thank you for using our platform!');
    }
}
