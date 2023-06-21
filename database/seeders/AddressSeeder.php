<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //\Illuminate\Support\Facades\DB::table('addresses')->truncate();
        
        $fact = new \Database\Factories\AddressFactory();
        $fact->count(25)->create();
    }
}
