<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
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
            'name' => fake()->firstName($sex),
            'sex' => $sex,
            'group_id' => fake()->randomFloat(0, 1, 2),
        ];
    }
}
