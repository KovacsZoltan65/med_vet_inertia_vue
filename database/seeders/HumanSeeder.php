<?php

namespace Database\Seeders;

use App\Models\Human;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HumanSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        for ($i = 0; $i <= 10; $i++) {
            Human::create([
                'name' => "Human {$i}",
                'type_id' => 1,
            ]);
        }
    }

}
