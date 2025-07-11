<?php

namespace database\factories;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserDetailFactory extends Factory
{
    protected $model = UserDetail::class;

    public function definition(): array
    {
        return [
            'money' => $this->faker->numberBetween(1000, 100000),
            'power' => $this->faker->numberBetween(10, 100),
        ];
    }
}
