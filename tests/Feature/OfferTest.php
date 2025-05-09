<?php

use Tests\TestCase;
use App\Models\Offer;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class OfferTest extends TestCase
{
    use \Tests\RefreshTestDatabase;

    #[Test]
    public function it_can_create_an_offer()
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
    public function it_can_edit_an_offer()
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
    public function it_can_list_all_offers()
    {
        $response = $this->get(route('offers.listado'));

        $response->assertStatus(200);
        $response->assertViewIs('marketplace');
        $response->assertViewHas('ofertas');
        $this->assertGreaterThanOrEqual(1, count($response->viewData('ofertas')));
    }
}