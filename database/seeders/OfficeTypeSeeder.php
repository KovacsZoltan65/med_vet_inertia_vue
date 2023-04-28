<?php

namespace Database\Seeders;

use App\Models\OfficeType;
use Database\Factories\OfficeTypeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OfficeType::create(['name' => 'Iroda']);
        OfficeType::create(['name' => 'Váró']);
        OfficeType::create(['name' => 'Kötöző']);
        OfficeType::create(['name' => 'Megfigyelő']);
        OfficeType::create(['name' => 'Műtő']);
    }
}
