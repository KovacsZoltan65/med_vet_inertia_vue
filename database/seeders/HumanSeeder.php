<?php

namespace Database\Seeders;

use Database\Factories\HumanFactory;
use Illuminate\Database\Seeder;

class HumanSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //\Illuminate\Support\Facades\DB::table('humans')->truncate();
        
        $fact = new HumanFactory();
        $fact->count(25)->create();
    }

}
