<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class ServiceTest extends TestCase
{
    // use RefreshDatabase;

    #[Test]
    public function it_can_add_a_service()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $serviceData = [
            'title' => 'Test Service',
            'description' => 'This is a test service.',
            'price' => 100,
            'stock' => 10,
        ];

        $response = $this->post(route('service.store'), $serviceData);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseHas('services', [
            'title' => 'Test Service',
            'description' => 'This is a test service.',
            'price' => 100,
            'stock' => 10,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function it_can_edit_a_service()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $updatedData = [
            'title' => 'Updated Service',
            'description' => 'This is an updated test service.',
            'price' => 150,
            'stock' => 5,
        ];

        $response = $this->post(route('service.store', ['id_servicio' => $service->id]), $updatedData);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Updated Service',
            'description' => 'This is an updated test service.',
            'price' => 150,
            'stock' => 5,
        ]);
    }

    #[Test]
    public function it_can_delete_a_service()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete('/eliminar_servicio/' . $service->id);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    #[Test]
    public function it_can_list_all_services()
    {
        $response = $this->get(route('services.listado'));

        $response->assertStatus(200);
        $response->assertViewIs('services.service');
        $response->assertViewHas('services');
        $this->assertGreaterThanOrEqual(1, count($response->viewData('services')));
    }
}