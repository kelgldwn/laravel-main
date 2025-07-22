<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'trainer_id',
        'booking_date',
        'booking_time',
        'status',
    ];

    // ✅ This is what Laravel expects when you do $booking->client
    public function client() {
        return $this->belongsTo(\App\Models\User::class, 'client_id');
    }

    public function trainer() {
        return $this->belongsTo(\App\Models\User::class, 'trainer_id');
    }
}
