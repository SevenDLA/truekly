<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition()
    {
        return [
            'user_seller_id' => User::factory(),
            'tokens' => $this->faker->numberBetween(10, 1000),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'status' => 'P', // Default status: Pending
        ];
    }
}