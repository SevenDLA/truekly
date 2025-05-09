<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $password;
        
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'sex' => $this->faker->randomElement(['H', 'M']),
            'date_of_birth' => $this->faker->date(),
            'phone_number' => substr($this->faker->numerify('##########'), 0, 10),
            'email_verified_at' => now(),
            'password' => $password ?: $password = Hash::make('password'),
            'remember_token' => Str::random(10),
            'tokens' => 0,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}