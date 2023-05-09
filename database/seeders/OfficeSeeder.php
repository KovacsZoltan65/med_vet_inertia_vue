<?php

namespace Database\Seeders;

use Database\Factories\OfficeFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offices')->truncate();
        
        $fact = new OfficeFactory();
        $fact->count(15)->create();
    }
}
