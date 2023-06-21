<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sex = fake()->randomFloat(0, 1, 2);
        
        return [
            'name_first' => fake()->firstName($sex),
            'name_last' => fake()->lastName(),
            'description' => fake()->sentence(),
            'email' => fake()->email(),
        ];
    }
}
