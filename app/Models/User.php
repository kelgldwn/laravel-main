<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Filament Authentication - STRICT ADMIN ONLY
    public function canAccessPanel(Panel $panel): bool
    {
        // Only allow access to admin panel if user has admin roles
        if ($panel->getId() === 'admin') {
            return $this->hasAnyRole(['admin', 'super-admin']);
        }
        
        return false;
    }

    // Relationships
    public function clientBookings()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function trainerBookings()
    {
        return $this->hasMany(Booking::class, 'trainer_id');
    }
}
