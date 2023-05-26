<?php

namespace Database\Seeders;

use Database\Factories\ExaminationFactory;
use Illuminate\Database\Seeder;

class ExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //\Illuminate\Support\Facades\DB::table('examinations')->truncate();
        
        $fact = new ExaminationFactory();
        $fact->count(100)->create();
    }
}
