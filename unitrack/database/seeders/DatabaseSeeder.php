<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Ensure a known admin account exists for development/testing. Use updateOrCreate
        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'role' => 'admin',
            'password' => Hash::make('adminpass'),
            'email_verified_at' => now(),
        ]);

        // Seed a teacher account for testing / quick access
        User::updateOrCreate([
            'email' => 'teacher@example.com',
        ], [
            'name' => 'Teacher Account',
            'role' => 'teacher',
            'password' => Hash::make('teacherpass'),
            'email_verified_at' => now(),
        ]);

        $this->call(ModulesSeeder::class);
    }
}
