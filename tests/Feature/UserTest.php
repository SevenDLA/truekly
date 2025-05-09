<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function puede_crear_una_cuenta()
    {
        $email = 'test.' . Str::random(10) . '@example.com';
        $username = 'user_' . Str::random(10);

        $userData = [
            'name' => 'Test',
            'surname' => 'User',
            'username' => $username,
            'email' => $email,
            'sex' => 'H',
            'date_of_birth' => '2000-01-01',
            'phone_number' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'oper' => 'registrarse'
        ];

        $response = $this->post(route('enviar.registrarse'), $userData);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function puede_iniciar_sesion()
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $response = $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function puede_cerrar_sesion()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    #[Test]
    public function puede_editar_perfil_usuario()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $datosPerfilActualizados = [
            'name' => 'Nombre Actualizado',
            'email' => 'correoactualizdo@example.com',
        ];

        $response = $this->patch(route('profile.update'), $datosPerfilActualizados);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nombre Actualizado',
            'email' => 'correoactualizdo@example.com',
        ]);
    }
}