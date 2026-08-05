<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@wecare.test'],
            ['name' => 'Admin User', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'doctor@wecare.test'],
            ['name' => 'Dr. Reyes', 'password' => bcrypt('password'), 'role' => 'doctor']
        );

        User::updateOrCreate(
            ['email' => 'receptionist@wecare.test'],
            ['name' => 'Receptionist User', 'password' => bcrypt('password'), 'role' => 'receptionist']
        );
    }
}