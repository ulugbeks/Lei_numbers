<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create test user
        $testUser = User::create([
            'name' => 'John Doe',
            'email' => 'test@lei-register.co.uk',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Test user created:');
        $this->command->info('Email: test@lei-register.co.uk');
        $this->command->info('Password: password123');

        // Create some LEI registrations for the test user
        
        // 1. Active LEI registration (paid)
        Contact::create([
            'user_id' => $testUser->id,
            'type' => 'registration',
            'country' => 'GB',
            'full_name' => 'John Doe',
            'legal_entity_name' => 'Test Company Ltd',
            'registration_id' => 'GB12TESTLEI1234567890',
            'email' => 'test@lei-register.co.uk',
            'phone' => '+44 20 1234 5678',
            'address' => '123 Test Street',
            'city' => 'London',
            'zip_code' => 'SW1A 1AA',
            'selected_plan' => '3-years',
            'amount' => 195.00,
            'same_address' => true,
            'private_controlled' => false,
            'payment_status' => 'paid',
            'created_at' => now()->subMonths(6),
            'updated_at' => now()->subMonths(6),
        ]);

        // 2. Another active LEI (1 year plan)
        Contact::create([
            'user_id' => $testUser->id,
            'type' => 'registration',
            'country' => 'US',
            'full_name' => 'John Doe',
            'legal_entity_name' => 'Test US Corporation',
            'registration_id' => 'US34TESTLEI0987654321',
            'email' => 'test@lei-register.co.uk',
            'phone' => '+1 212 555 1234',
            'address' => '456 Business Ave',
            'city' => 'New York',
            'zip_code' => '10001',
            'selected_plan' => '1-year',
            'amount' => 75.00,
            'same_address' => true,
            'private_controlled' => false,
            'payment_status' => 'paid',
            'created_at' => now()->subYear(),
            'updated_at' => now()->subYear(),
        ]);

        // 3. Pending payment LEI
        Contact::create([
            'user_id' => $testUser->id,
            'type' => 'registration',
            'country' => 'DE',
            'full_name' => 'John Doe',
            'legal_entity_name' => 'Test GmbH',
            'registration_id' => 'PENDING123456789012',
            'email' => 'test@lei-register.co.uk',
            'phone' => '+49 30 12345678',
            'address' => '789 Berlin Street',
            'city' => 'Berlin',
            'zip_code' => '10115',
            'selected_plan' => '5-years',
            'amount' => 275.00,
            'same_address' => true,
            'private_controlled' => true,
            'payment_status' => 'pending',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        // 4. Renewal record
        Contact::create([
            'user_id' => $testUser->id,
            'type' => 'renewal',
            'country' => 'GB',
            'full_name' => 'John Doe',
            'legal_entity_name' => 'Test Company Ltd - Renewal',
            'registration_id' => 'GB12TESTLEI1234567890',
            'email' => 'test@lei-register.co.uk',
            'phone' => '+44 20 1234 5678',
            'address' => '123 Test Street',
            'city' => 'London',
            'zip_code' => 'SW1A 1AA',
            'selected_plan' => '3-years',
            'amount' => 195.00,
            'same_address' => true,
            'private_controlled' => false,
            'payment_status' => 'paid',
            'created_at' => now()->subMonth(),
            'updated_at' => now()->subMonth(),
        ]);

        // 5. Transfer record
        Contact::create([
            'user_id' => $testUser->id,
            'type' => 'transfer',
            'country' => 'FR',
            'full_name' => 'John Doe',
            'legal_entity_name' => 'Test SARL',
            'registration_id' => 'FR56TESTLEI5678901234',
            'email' => 'test@lei-register.co.uk',
            'phone' => '+33 1 23 45 67 89',
            'address' => '321 Rue de Test',
            'city' => 'Paris',
            'zip_code' => '75001',
            'selected_plan' => '1-year',
            'amount' => 75.00,
            'same_address' => true,
            'private_controlled' => false,
            'payment_status' => 'paid',
            'created_at' => now()->subWeeks(3),
            'updated_at' => now()->subWeeks(3),
        ]);

        $this->command->info('5 LEI registrations created for test user');

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@lei-register.co.uk',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created:');
        $this->command->info('Email: admin@lei-register.co.uk');
        $this->command->info('Password: admin123');

        // Create another regular user with no LEI registrations
        $emptyUser = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Empty user created (no LEI registrations):');
        $this->command->info('Email: jane@example.com');
        $this->command->info('Password: password123');
    }
}

