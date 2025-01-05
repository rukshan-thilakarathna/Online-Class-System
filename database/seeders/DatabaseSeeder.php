<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'rukshan',
            'email' => 'ruky@gmail.com',
            'password' => bcrypt('3066924'),
            'email_verified_at' => now(),

        ]);

        Classes::factory()
            ->count(100)
            ->create();
    }
}
