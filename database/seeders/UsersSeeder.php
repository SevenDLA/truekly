<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'          => 'John',
                'surname'       => 'Doe',
                'username'      => 'johndoe',
                'email'         => 'sb-ralc438527279@personal.example.com',
                'sex'           => 'H',
                'date_of_birth' => '1990-05-15',
                'phone_number'  => '1234567890',
                'password'      => Hash::make('password123'),
                'tokens'        => 10000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Jane',
                'surname'       => 'Smith',
                'username'      => 'janesmith',
                'email'         => 'sb-lfwzw41141216@personal.example.com',
                'sex'           => 'M',
                'date_of_birth' => '1995-08-22',
                'phone_number'  => '0987654321',
                'password'      => Hash::make('securepass'),
                'tokens'        => 1000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'admin',
                'surname'       => 'admin',
                'username'      => 'admin',
                'email'         => 'admin@gmail.com',
                'sex'           => 'H',
                'date_of_birth' => '1995-08-22',
                'phone_number'  => '0987654321',
                'password'      => Hash::make('a'),
                'tokens'        => 0,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        $admin = Role::create(['name' => 'admin']);
        $user = User::find(3);
        $user->assignRole('admin');
    }
}
