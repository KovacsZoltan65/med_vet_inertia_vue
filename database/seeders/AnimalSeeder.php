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
        //\Illuminate\Support\Facades\DB::table('animals')->truncate();
        
        $fact = new AnimalFactory();
        $fact->count(15)->create();
    }
}
