<?php

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use \Tests\RefreshTestDatabase;

    #[Test]
    public function it_can_create_an_account()
    {
        $userData = [
            'name' => 'Test',
            'surname' => 'User',
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'sex' => 'H',
            'date_of_birth' => '2000-01-01',
            'phone_number' => '123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('users.almacenar'), $userData);

        $response->assertRedirect(route('users.listado'));
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    #[Test]
    public function it_can_log_in()
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
    public function it_can_log_out()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    #[Test]
    public function it_can_edit_user_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $updatedProfileData = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ];

        $response = $this->patch(route('profile.update'), $updatedProfileData);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);
    }
}