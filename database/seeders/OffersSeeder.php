<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user IDs
        $johnId = DB::table('users')->where('username', 'johndoe')->value('id');
        $janeId = DB::table('users')->where('username', 'janesmith')->value('id');

        // Insert offers from Jane
        DB::table('offers')->insert([
            [
                'user_seller_id' => $janeId,
                'tokens'         => 100,
                'price'          => 50,
                'status'         => 'E',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_seller_id' => $janeId,
                'tokens'         => 200,
                'price'          => 900,
                'status'         => 'E',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
