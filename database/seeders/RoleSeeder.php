<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $trainerRole = Role::firstOrCreate(['name' => 'trainer']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Create permissions
        $permissions = [
            'access_admin_panel',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_bookings',
            'create_bookings',
            'edit_bookings',
            'delete_bookings',
            'manage_system',
            'view_dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to admin roles
        $adminRole->givePermissionTo([
            'access_admin_panel',
            'view_dashboard',
            'view_users',
            'create_users',
            'edit_users',
            'view_bookings',
            'create_bookings',
            'edit_bookings',
        ]);

        $superAdminRole->givePermissionTo(Permission::all());

        $this->command->info('Roles and permissions created successfully!');
    }
}
