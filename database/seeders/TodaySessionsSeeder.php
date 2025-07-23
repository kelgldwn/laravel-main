<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class TodaySessionsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get or create trainer
        $trainer = User::where('email', 'trainer@example.com')->first();
        if (!$trainer) {
            $trainer = User::create([
                'name' => 'John Trainer',
                'email' => 'trainer@example.com',
                'password' => bcrypt('password'),
            ]);
            $trainer->assignRole('trainer');
        }

        // Get or create some clients
        $clients = [];
        for ($i = 1; $i <= 4; $i++) {
            $client = User::firstOrCreate(
                ['email' => "client{$i}@example.com"],
                [
                    'name' => "Client {$i}",
                    'password' => bcrypt('password'),
                ]
            );
            if (!$client->hasRole('client')) {
                $client->assignRole('client');
            }
            $clients[] = $client;
        }

        // Create today's sessions at different times
        $todayTimes = ['09:00:00', '11:00:00', '14:00:00', '16:00:00'];
        
        foreach ($todayTimes as $index => $time) {
            if (isset($clients[$index])) {
                Booking::firstOrCreate([
                    'trainer_id' => $trainer->id,
                    'client_id' => $clients[$index]->id,
                    'booking_date' => Carbon::today()->format('Y-m-d'),
                    'booking_time' => $time,
                ], [
                    'status' => 'approved',
                ]);
            }
        }

        // Create some sessions for tomorrow and next few days
        for ($day = 1; $day <= 3; $day++) {
            $futureDate = Carbon::today()->addDays($day);
            foreach (['10:00:00', '15:00:00'] as $index => $time) {
                if (isset($clients[$index])) {
                    Booking::firstOrCreate([
                        'trainer_id' => $trainer->id,
                        'client_id' => $clients[$index]->id,
                        'booking_date' => $futureDate->format('Y-m-d'),
                        'booking_time' => $time,
                    ], [
                        'status' => 'approved',
                    ]);
                }
            }
        }

        $this->command->info('Today\'s sessions seeded successfully!');
    }
}
