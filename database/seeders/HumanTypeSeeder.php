<?php

namespace Database\Seeders;

use App\Models\HumanType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HumanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i <= 5; $i++){
            HumanType::create([
                'name' => "HumanType {$i}",
            ]);
        }
    }
}
