<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

test('se puede mostrar la pantalla de inicio de sesión', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('los usuarios pueden autenticarse usando email', function () {
    DB::table('users')->where('email', 'test@example.com')->delete();
    
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'login' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/');
});

test('los usuarios pueden autenticarse usando nombre de usuario', function () {
    DB::table('users')->where('username', 'testuser')->delete();
    
    $user = User::factory()->create([
        'username' => 'testuser',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'login' => $user->username,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/');
});

test('los usuarios no pueden autenticarse con contraseña inválida', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->post('/login', [
        'login' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('los usuarios pueden cerrar sesión', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
