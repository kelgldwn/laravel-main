<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainerDashboardController extends Controller
{
    /**
     * Display the trainer dashboard.
     */
    public function index()
    {
        $trainer = Auth::user();
    
        // Get today's sessions - approved bookings for today
        $todaysSessions = $trainer->trainerBookings()
            ->with('client')
            ->where('status', 'approved')
            ->whereDate('booking_date', Carbon::today())
            ->orderBy('booking_time')
            ->get();
        
        // Get recent bookings
        $recentBookings = $trainer->trainerBookings()
            ->with('client')
            ->latest()
            ->take(5)
            ->get();
        
        // Get upcoming bookings (next 7 days, excluding today)
        $upcomingBookings = $trainer->trainerBookings()
            ->with('client')
            ->where('status', 'approved')
            ->where('booking_date', '>', Carbon::today())
            ->where('booking_date', '<=', Carbon::today()->addDays(7))
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->take(5)
            ->get();
        
        // Get stats
        $totalBookings = $trainer->trainerBookings()->count();
        $totalClients = $trainer->trainerBookings()->distinct('client_id')->count('client_id');
        
        // Get today's stats
        $todaysBookingsCount = $todaysSessions->count();
        $pendingBookingsCount = $trainer->trainerBookings()->where('status', 'pending')->count();
        
        // Calculate earnings (if earnings table exists)
        $totalEarnings = 0;
        $thisMonthEarnings = 0;
        try {
            $totalEarnings = $trainer->earnings()->where('status', 'paid')->sum('net_amount');
            $thisMonthEarnings = $trainer->earnings()
                ->where('status', 'paid')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('net_amount');
        } catch (\Exception $e) {
            // Earnings table might not exist yet
        }
        
        // Get average rating (if reviews table exists)
        $averageRating = 0;
        try {
            $averageRating = $trainer->trainerReviews()->avg('rating') ?? 0;
        } catch (\Exception $e) {
            // Reviews table might not exist yet
        }
        
        return view('trainer.dashboard', compact(
            'todaysSessions',
            'recentBookings', 
            'upcomingBookings', 
            'totalBookings', 
            'totalClients', 
            'totalEarnings',
            'thisMonthEarnings',
            'averageRating',
            'todaysBookingsCount',
            'pendingBookingsCount'
        ));
    }

    /**
     * Display the trainer's clients.
     */
    public function clients()
    {
        $trainer = Auth::user();
        
        // Get unique clients who have booked with this trainer
        $clientIds = $trainer->trainerBookings()
            ->distinct('client_id')
            ->pluck('client_id');
            
        $clients = User::whereIn('id', $clientIds)
            ->withCount(['clientBookings as completed_sessions' => function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id)
                      ->where('status', 'completed');
            }])
            ->withCount(['clientBookings as upcoming_sessions' => function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id)
                      ->where('status', 'approved')
                      ->where('booking_date', '>=', Carbon::today());
            }])
            ->get();
            
        foreach ($clients as $client) {
            // Get the last booking date - using correct column name
            $lastBooking = $trainer->trainerBookings()
                ->where('client_id', $client->id)
                ->latest('booking_date')
                ->first();
                
            $client->last_session = $lastBooking ? $lastBooking->booking_date : null;
            $client->average_rating = 0; // Set to 0 for now
        }
        
        return view('trainer.clients', compact('clients'));
    }

    /**
     * Display the trainer's reviews.
     */
    public function reviews()
    {
        // For now, return empty data since Review model might not exist
        $reviews = collect();
        $averageRating = 0;
        $reviewCount = 0;
        $ratingBreakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        
        return view('trainer.reviews', compact('reviews', 'averageRating', 'reviewCount', 'ratingBreakdown'));
    }

    /**
     * Display the trainer's earnings.
     */
    public function earnings()
    {
        // For now, return empty data since Earning model might not exist
        $earnings = collect();
        $totalEarnings = 0;
        $pendingEarnings = 0;
        $paidEarnings = 0;
        $monthlyEarnings = collect();
        
        return view('trainer.earnings', compact(
            'earnings', 
            'totalEarnings', 
            'pendingEarnings', 
            'paidEarnings',
            'monthlyEarnings'
        ));
    }

    /**
     * Display the trainer's performance metrics.
     */
    public function performance()
    {
        $trainer = Auth::user();
        
        // Booking completion rate
        $totalBookings = $trainer->trainerBookings()->count();
        $completedBookings = $trainer->trainerBookings()->where('status', 'completed')->count();
        $completionRate = $totalBookings > 0 ? ($completedBookings / $totalBookings) * 100 : 0;
        
        // Client retention rate
        $repeatClients = $trainer->trainerBookings()
            ->selectRaw('client_id, COUNT(*) as booking_count')
            ->groupBy('client_id')
            ->having('booking_count', '>', 1)
            ->count();
        $totalClients = $trainer->trainerBookings()->distinct('client_id')->count('client_id');
        $retentionRate = $totalClients > 0 ? ($repeatClients / $totalClients) * 100 : 0;
        
        // Monthly bookings for chart - using correct column name
        $monthlyBookings = $trainer->trainerBookings()
            ->selectRaw('YEAR(booking_date) as year, MONTH(booking_date) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1);
                return [
                    'month' => $date->format('M Y'),
                    'total' => $item->total
                ];
            });
            
        // Get popular time slots - using correct column name
        $popularTimeSlots = $trainer->trainerBookings()
            ->selectRaw('HOUR(booking_time) as hour, COUNT(*) as total')
            ->groupBy('hour')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $hour = $item->hour;
                $formattedHour = Carbon::createFromTime($hour, 0, 0)->format('g:i A');
                return [
                    'time' => $formattedHour,
                    'total' => $item->total
                ];
            });
            
        return view('trainer.performance', compact(
            'completionRate', 
            'retentionRate', 
            'monthlyBookings', 
            'popularTimeSlots'
        ));
    }
}
