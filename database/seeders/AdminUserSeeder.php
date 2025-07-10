<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@lei-register.co.uk'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'), // Change this password
                'first_name' => 'Admin',
                'last_name' => 'User',
                'company_name' => 'LEI Register',
                'phone' => '+44 20 8040 0288',
                'address_line_1' => 'International House',
                'address_line_2' => '6 South Molton St.',
                'city' => 'London',
                'state' => 'England',
                'country' => 'GB',
                'postal_code' => 'EW1K 5QF',
                'role' => 'admin',
                'email_verified_at' => now(),
                'terms_accepted' => true,
                'privacy_accepted' => true,
                'terms_accepted_at' => now(),
                'privacy_accepted_at' => now(),
            ]
        );

        // Create a test regular user
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'password' => Hash::make('password'), // Change this password
                'first_name' => 'Test',
                'last_name' => 'User',
                'company_name' => 'Test Company',
                'phone' => '+1 234 567 8900',
                'address_line_1' => '123 Test Street',
                'city' => 'Test City',
                'country' => 'US',
                'postal_code' => '12345',
                'role' => 'user',
                'email_verified_at' => now(),
                'terms_accepted' => true,
                'privacy_accepted' => true,
                'terms_accepted_at' => now(),
                'privacy_accepted_at' => now(),
            ]
        );

        $this->command->info('Admin and test user created successfully!');
        $this->command->info('Admin login: admin@lei-register.co.uk / Admin@123456');
        $this->command->info('User login: user@example.com / User@123456');
    }
}