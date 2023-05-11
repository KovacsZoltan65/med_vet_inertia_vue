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
            //UserSeeder::class,
            //BookSeeder::class,
            //CompanySeeder::class,
            //OfficeSeeder::class,
            //HumanSeeder::class,
            //AnimalSeeder::class,
            //PatientSeeder::class,
            
            AddressesSeeder::class,
        ]);
    }
}
