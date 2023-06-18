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
        $data = [
            [
                'id' => 1,
                'name' => 'ADMIN',
                'label' => 'Admin',
            ],
            [
                'id' => 2,
                'name' => 'USER',
                'label' => 'User',
            ],
            [
                'id' => 3,
                'name' => 'ORVOS',
                'label' => 'Orvos',
            ],
            [
                'id' => 4,
                'name' => 'ASSZISZTENS',
                'label' => 'Asszisztens',
            ],
            [
                'id' => 5,
                'name' => 'RECEPCIOS',
                'label' => 'Recepciós',
            ],
            [
                'id' => 6,
                'name' => 'BETEGHORDO',
                'label' => 'Beteghordó',
            ]
        ];

        HumanType::insert($data);
    }
}
