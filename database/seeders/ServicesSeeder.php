<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $johnId = DB::table('users')->where('username', 'johndoe')->value('id');

        // Insert services for John
        DB::table('services')->insert([
            [
                'user_id'     => $johnId,
                'title'       => 'Web Development',
                'description' => 'Professional website development using Laravel.',
                'price'       => 500,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $johnId,
                'title'       => 'Graphic Design',
                'description' => 'Custom logo and branding design services.',
                'price'       => 300,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
