<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Earning;
use App\Models\TrainerProfile;
use Carbon\Carbon;

class TrainerDataSeeder extends Seeder
{
    public function run()
    {
        // Create sample trainer if doesn't exist
        $trainer = User::where('email', 'trainer@example.com')->first();
        if (!$trainer) {
            $trainer = User::create([
                'name' => 'John Trainer',
                'email' => 'trainer@example.com',
                'password' => bcrypt('password'),
            ]);
            $trainer->assignRole('trainer');
        }

        // Create trainer profile
        TrainerProfile::updateOrCreate(
            ['user_id' => $trainer->id],
            [
                'bio' => 'Certified personal trainer with 5+ years of experience in strength training and weight loss.',
                'specializations' => ['Strength Training', 'Weight Loss', 'HIIT', 'Nutrition'],
                'experience_years' => 5,
                'certifications' => ['NASM-CPT', 'Nutrition Specialist'],
                'hourly_rate' => 75.00,
                'is_active' => true
            ]
        );

        // Create sample clients
        $clients = [];
        for ($i = 1; $i <= 10; $i++) {
            $client = User::create([
                'name' => "Client $i",
                'email' => "client$i@example.com",
                'password' => bcrypt('password'),
            ]);
            $client->assignRole('client');
            $clients[] = $client;
        }

        // Create sample bookings
        foreach ($clients as $index => $client) {
            // Create multiple bookings for each client
            for ($j = 0; $j < rand(2, 5); $j++) {
                $booking = Booking::create([
                    'trainer_id' => $trainer->id,
                    'client_id' => $client->id,
                    'booking_date' => Carbon::now()->addDays(rand(-30, 30)),
                    'booking_time' => sprintf('%02d:00:00', rand(8, 18)),
                    'status' => ['approved', 'pending', 'declined'][rand(0, 2)]
                ]);

                // Create earnings for approved bookings
                if ($booking->status === 'approved') {
                    Earning::create([
                        'trainer_id' => $trainer->id,
                        'booking_id' => $booking->id,
                        'amount' => 75.00,
                        'commission' => 7.50,
                        'net_amount' => 67.50,
                        'status' => 'paid'
                    ]);

                    // Create reviews for some completed sessions
                    if (rand(0, 1)) {
                        Review::create([
                            'trainer_id' => $trainer->id,
                            'client_id' => $client->id,
                            'booking_id' => $booking->id,
                            'rating' => rand(4, 5),
                            'comment' => [
                                'Great session! Really helped me with my form.',
                                'Excellent trainer, very knowledgeable and motivating.',
                                'Amazing workout, I can already see improvements!',
                                'Professional and friendly. Highly recommend!',
                                'Best trainer I\'ve worked with. Results speak for themselves.'
                            ][rand(0, 4)]
                        ]);
                    }
                }
            }
        }
    }
}
