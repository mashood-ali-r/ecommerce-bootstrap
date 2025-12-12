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
        // Seed categories first
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        // Create an admin user
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@eezepc.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
