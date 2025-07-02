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
    protected static ?string $password;

    public function definition(): array
    {
        $scheduled_date = $this->faker->dateTimeBetween('+1day', '+1year');
        return [
            'name' => $this->faker->unique()->name(),
            'level' => $this->faker->numberBetween(1, 100),
            'exp' => $this->faker->randomNumber(8),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
