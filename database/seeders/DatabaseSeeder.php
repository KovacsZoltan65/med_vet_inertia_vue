<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OfficeType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            //BookSeeder::class,
            //CompanySeeder::class,
            OfficeSeeder::class,
            OfficeTypeSeeder::class
        ]);
    }
}
