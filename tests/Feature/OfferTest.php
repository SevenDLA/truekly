<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Offer;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class OfferTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function puede_crear_una_oferta()
    {
        $user = User::factory()->create(['tokens' => 500]);

        $this->actingAs($user);

        $offerData = [
            'tokens' => 100,
            'price' => 50,
        ];

        $response = $this->post(route('offer.store'), $offerData);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseHas('offers', [
            'user_seller_id' => $user->id,
            'tokens' => 100,
            'price' => 50,
            'status' => 'P',
        ]);
    }

    #[Test]
    public function puede_editar_una_oferta()
    {
        $user = User::factory()->create(['tokens' => 500]);
        $offer = Offer::factory()->create([
            'user_seller_id' => $user->id,
            'tokens' => 100,
            'price' => 50,
            'status' => 'P',
        ]);

        $this->actingAs($user);

        $updatedOfferData = [
            'tokens' => 200,
            'price' => 100,
        ];

        $response = $this->post(route('offer.store', ['id_oferta' => $offer->id]), $updatedOfferData);

        $response->assertRedirect(route('profile.normal'));
        $this->assertDatabaseHas('offers', [
            'id' => $offer->id,
            'tokens' => 200,
            'price' => 100,
        ]);
    }

    #[Test]
    public function puede_listar_todas_las_ofertas()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // Add authentication

        // Create a test offer
        Offer::factory()->create([
            'user_seller_id' => $user->id,
            'tokens' => 100,
            'price' => 50,
            'status' => 'P',
        ]);

        $response = $this->get(route('offers.listado'));
        $response->assertStatus(200);
        $response->assertViewIs('marketplace');
        $response->assertViewHas('ofertas');
        $this->assertGreaterThanOrEqual(1, count($response->viewData('ofertas')));
    }
}