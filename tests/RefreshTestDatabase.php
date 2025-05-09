<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

trait RefreshTestDatabase
{
    use RefreshDatabase;

    public function refreshTestDatabase()
    {
        $this->artisan('migrate:fresh', [
            '--seed' => true,
            '--env' => 'testing',
        ]);

        $this->beforeApplicationDestroyed(function () {
            // Obtener los IDs originales de los seeders
            $originalUserIds = DB::table('users')->whereIn('username', ['johndoe', 'janesmith', 'admin'])->pluck('id');
            $originalServiceIds = DB::table('services')->whereIn('user_id', $originalUserIds)->pluck('id');
            
            // Eliminar solo los registros que no son de los seeders
            DB::table('users')->whereNotIn('id', $originalUserIds)->delete();
            DB::table('services')->whereNotIn('id', $originalServiceIds)->delete();
            DB::table('offers')->whereNotIn('user_seller_id', $originalUserIds)->delete();
        });
    }
}
