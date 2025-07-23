<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'client_id',
        'booking_id',
        'rating',
        'comment',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Scope for approved reviews only
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Get average rating for a trainer
    public static function averageRatingForTrainer($trainerId)
    {
        return self::where('trainer_id', $trainerId)
            ->approved()
            ->avg('rating') ?? 0;
    }
}
