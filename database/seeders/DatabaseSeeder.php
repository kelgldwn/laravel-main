<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Make sure roles exist first
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'trainer']);
        Role::firstOrCreate(['name' => 'client']);

        // Then create users and assign roles
        $this->call([
            UserSeeder::class,
        ]);
    }
}
