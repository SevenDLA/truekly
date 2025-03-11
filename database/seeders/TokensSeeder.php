<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tokens')->insert([
            ['amount' => 100, 'price' => 4.99],
            ['amount' => 250, 'price' => 9.99],
            ['amount' => 500, 'price' => 24.99],
            ['amount' => 1000, 'price' => 45.99],
            ['amount' => 2000, 'price' => 99.99],
        ]);
    }
}
