<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure admin roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@trainerbook.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Remove any existing roles and assign super-admin
        $superAdmin->syncRoles(['super-admin']);

        // Create Regular Admin
        $admin = User::firstOrCreate(
            ['email' => 'manager@trainerbook.com'],
            [
                'name' => 'Admin Manager',
                'password' => Hash::make('manager123'),
                'email_verified_at' => now(),
            ]
        );

        // Remove any existing roles and assign admin
        $admin->syncRoles(['admin']);

        $this->command->info('Admin users created successfully:');
        $this->command->line('Super Admin: admin@trainerbook.com / admin123');
        $this->command->line('Manager: manager@trainerbook.com / manager123');
    }
}
