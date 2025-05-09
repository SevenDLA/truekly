<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_se_puede_mostrar_la_pantalla_de_registro()
    {
        $response = $this->get('/registrarse');
        $response->assertStatus(200);
    }

    public function test_los_nuevos_usuarios_pueden_registrarse()
    {
        $email = 'test.' . Str::random(10) . '@example.com';
        $username = 'user_' . Str::random(10);

        $response = $this->post('/nuevo/registro', [
            'name' => 'Usuario Prueba',
            'surname' => 'Apellido Prueba',
            'username' => $username,
            'email' => $email,
            'sex' => 'H',
            'date_of_birth' => '2000-01-01',
            'phone_number' => '1234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
            'oper' => 'registrarse'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }
}
