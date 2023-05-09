<?php

namespace Database\Seeders;

use Database\Factories\HumanFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HumanSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('humans')->truncate();
        
        $fact = new HumanFactory();
        $fact->count(25)->create();
    }

}
