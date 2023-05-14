<?php

namespace Database\Seeders;

use Database\Factories\ExaminationFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('examinations')->truncate();
        
        $fact = new ExaminationFactory();
        $fact->count(100)->create();
    }
}
