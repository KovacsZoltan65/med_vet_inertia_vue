<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Addresses>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $human_id = fake()->randomFloat(0, 1, 25);
        $company_id = 0;
        
        if($human_id === 0)
        {
            $company_id = fake()->randomFloat(0, 1, 100);
        }
        
        return [
            'company_id' => $company_id, // 100
              'human_id' => $human_id, // 25
               'type_id' => fake()->randomFloat(0, 1, 3),
                  'city' => fake()->city(),
               'address' => fake()->address(),
        ];
    }
}
