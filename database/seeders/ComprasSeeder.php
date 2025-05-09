<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ComprasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('compras')->insert([
            'user_buyer_id' => 1,
            'user_seller_id' => 2,
            'service_id'     => 6,
            'status'         => 'P',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}
