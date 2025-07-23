<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('Active Trainers', User::role('trainer')->count())
                ->description('Professional trainers')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
            
            Stat::make('Total Clients', User::role('client')->count())
                ->description('Registered clients')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
            
            Stat::make('Pending Bookings', Booking::where('status', 'pending')->count())
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
            
            Stat::make('Today\'s Sessions', Booking::whereDate('booking_date', today())->where('status', 'confirmed')->count())
                ->description('Confirmed for today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
            
            Stat::make('This Month', Booking::whereMonth('booking_date', now()->month)->count())
                ->description('Total bookings this month')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
        ];
    }
}
