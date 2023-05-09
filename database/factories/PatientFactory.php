<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $d = fake()->dateTimeThisYear();
        
        $start_time = fake()->dateTimeBetween($d, '+30 minute');
        $final_time = fake()->dateTimeBetween($start_time, '+15 minute');
        
        $data = [
            'user_id' => 1,
            'doctor_id' => fake()->numberBetween(1, 5),
            'animal_id' => fake()->numberBetween(1, 5),
            'office_id' => fake()->numberBetween(1, 5),
            'treatment_id' => 0,
            'start_time' => $start_time,
            'final_time' => $final_time,
        ];
        //dd($data);
        
        return $data;
    }
}
