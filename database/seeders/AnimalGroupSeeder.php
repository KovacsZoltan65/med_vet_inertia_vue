<?php

namespace Database\Seeders;

use App\Models\AnimalGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'DOG',
                'label' => 'Dog',
            ],
            [
                'id' => 2,
                'name' => 'CAT',
                'label' => 'Cat',
            ]
        ];

        AnimalGroup::insert($data);
    }
}
