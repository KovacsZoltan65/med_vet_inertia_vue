<?php

namespace Database\Seeders;

use Database\Factories\AnimalFactory;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fact = new AnimalFactory();
        $fact->count(10)->create();
    }
}
