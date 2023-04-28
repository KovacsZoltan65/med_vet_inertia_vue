<?php

namespace Database\Seeders;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fact = new CompanyFactory();
        $fact->count(1000)->create();
    }
}
