<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        // Create a super admin with requested credentials
        // Create or update a super admin with requested credentials (idempotent)
        User::updateOrCreate(
            ['email' => 'ashikeron@gmail.com'],
            [
                'name'     => 'Ashik Super',
                'password' => Hash::make( '1234567' ),
                'role'     => 'super_admin',
            ]
        );

        // Keep a regular test user
        // Ensure a regular test user exists
        User::firstOrCreate( [
            'email' => 'test@example.com',
        ], [
            'name'     => 'Test User',
            'password' => Hash::make( 'password' ),
        ] );
    }
}
