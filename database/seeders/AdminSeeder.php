<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
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
        $user = User::find(1);
        $user->assignRole('admin');
    }
}
