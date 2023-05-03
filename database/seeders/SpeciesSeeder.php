<?php

namespace Database\Seeders;

use Database\Factories\SpeciesFactory;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$fact = new SpeciesFactory();
        //$fact->count(10)->create();
        \App\Models\Species::create(['name' => 'Emlősök']);
        \App\Models\Species::create(['name' => 'Madarak']);
        \App\Models\Species::create(['name' => 'Hüllők']);
    }
}
