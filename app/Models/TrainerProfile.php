<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'specializations',
        'experience_years',
        'certifications',
        'hourly_rate',
        'availability',
        'profile_image',
        'is_active'
    ];

    protected $casts = [
        'specializations' => 'array',
        'certifications' => 'array',
        'availability' => 'array',
        'hourly_rate' => 'decimal:2',
        'experience_years' => 'integer',
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
