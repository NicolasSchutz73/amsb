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
        // Configurer Faker pour utiliser la locale française
        $this->faker->locale('fr_FR');

        return [
            'firstname' => fake()->firstname(),
            'lastname' => fake()->lastname(),
            'email' => $this->faker->unique()->userName() . '@gmail.com',
            'email_verified_at' => now(),
            'description' => fake()->paragraph(),
            'emergency' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'profile_photo_path' => 'https://picsum.photos/400/400?random=' . $this->faker->unique()->numberBetween(1, 1000),
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
