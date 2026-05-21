<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin account
        User::firstOrCreate(
            ['email' => 'admin@listify.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create a test user account
        User::firstOrCreate(
            ['email' => 'user@listify.local'],
            [
                'name' => 'Test User',
                'password' => Hash::make('user123456'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        echo "\n✅ Admin & Test Users Created:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Admin Account:\n";
        echo "  Email: admin@listify.local\n";
        echo "  Password: admin123456\n";
        echo "  Role: Admin\n\n";
        echo "Test User Account:\n";
        echo "  Email: user@listify.local\n";
        echo "  Password: user123456\n";
        echo "  Role: User\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
