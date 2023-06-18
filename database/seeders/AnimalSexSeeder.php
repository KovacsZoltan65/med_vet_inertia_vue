<?php

namespace Database\Seeders;

use App\Models\AnimalSex;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalSexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'FEMALE',
                'label' => 'Female',
            ],
            [
                'id' => 2,
                'name' => 'MALE',
                'label' => 'Male',
            ]
        ];

        AnimalSex::insert($data);
    }
}
