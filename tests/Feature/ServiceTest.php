<?php

use Tests\TestCase;
use App\Models\Service;
use App\Models\User; 
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class ServiceTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function puede_agregar_un_servicio()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $serviceData = [
            'title' => 'Servicio de Prueba',
            'description' => 'Este es un servicio de prueba.',
            'price' => 100,
            'stock' => 10,
        ];

        $response = $this->post(route('service.store'), $serviceData);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseHas('services', [
            'title' => 'Servicio de Prueba',
            'description' => 'Este es un servicio de prueba.',
            'price' => 100,
            'stock' => 10,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function puede_editar_un_servicio()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $updatedData = [
            'title' => 'Servicio Actualizado',
            'description' => 'Este es un servicio de prueba actualizado.',
            'price' => 150,
            'stock' => 5,
        ];

        $response = $this->post(route('service.store', ['id_servicio' => $service->id]), $updatedData);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Servicio Actualizado',
            'description' => 'Este es un servicio de prueba actualizado.',
            'price' => 150,
            'stock' => 5,
        ]);
    }

    #[Test]
    public function puede_eliminar_un_servicio()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete('/eliminar_servicio/' . $service->id);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    #[Test]
    public function puede_listar_todos_los_servicios()
    {
        $response = $this->get(route('services.listado'));

        $response->assertStatus(200);
        $response->assertViewIs('services.service');
        $response->assertViewHas('services');
        $this->assertGreaterThanOrEqual(1, count($response->viewData('services')));
    }
}