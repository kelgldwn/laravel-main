<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'booking_id',
        'amount',
        'commission',
        'net_amount',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'paid_at' => 'datetime'
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
