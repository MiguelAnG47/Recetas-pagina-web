<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
        'nombre' => $this->faker->firstName(),
        'apellido' => $this->faker->lastName(),
        'email' => $this->faker->unique()->safeEmail(),
        'password' => bcrypt('password'),
        'edad' => $this->faker->numberBetween(18, 70),
    ];
    }
}
