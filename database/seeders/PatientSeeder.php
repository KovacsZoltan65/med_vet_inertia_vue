<?php

namespace Database\Seeders;

use Database\Factories\PatientFactory;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //\Illuminate\Support\Facades\DB::table('patients')->truncate();
        
        $fact = new PatientFactory();
        $fact->count(100)->create();
    }
}
