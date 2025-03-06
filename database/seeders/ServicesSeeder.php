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
        // Obtener el ID de johndoe
        $johnId = DB::table('users')->where('username', 'johndoe')->value('id');
        // Obtener el ID de janesmith
        $janeId = DB::table('users')->where('username', 'janesmith')->value('id');

        // Insertar 5 servicios para John
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
            [
                'user_id'     => $johnId,
                'title'       => 'SEO Optimization',
                'description' => 'Improve your website ranking with our SEO services.',
                'price'       => 400,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $johnId,
                'title'       => 'Mobile App Development',
                'description' => 'Build cross-platform mobile applications with Flutter.',
                'price'       => 700,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $johnId,
                'title'       => 'E-commerce Solutions',
                'description' => 'Create online stores with integrated payment systems.',
                'price'       => 600,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // Insertar 5 servicios para Jane
        DB::table('services')->insert([
            [
                'user_id'     => $janeId,
                'title'       => 'Content Writing',
                'description' => 'High-quality blog posts and articles for your website.',
                'price'       => 100,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $janeId,
                'title'       => 'Social Media Management',
                'description' => 'Manage and grow your social media presence.',
                'price'       => 200,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $janeId,
                'title'       => 'Video Editing',
                'description' => 'Professional video editing for YouTube and social media.',
                'price'       => 250,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $janeId,
                'title'       => 'Photography',
                'description' => 'High-quality photography for events and products.',
                'price'       => 350,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $janeId,
                'title'       => 'Email Marketing',
                'description' => 'Create and manage effective email marketing campaigns.',
                'price'       => 150,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}