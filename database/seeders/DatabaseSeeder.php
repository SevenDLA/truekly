<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\ServicesSeeder;
use Database\Seeders\TokensSeeder;
use Database\Seeders\OffersSeeder;
use Database\Seeders\ComprasSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        $this->call([
            UsersSeeder::class, 
            ServicesSeeder::class,
            TokensSeeder::class,
            OffersSeeder::class,
            ComprasSeeder::class
        ]);

        
    }
}
