<?php

namespace Database\Seeders;

use App\Models\OfficeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'IRODA',
                'label' => 'Iroda',
            ],
            [
                'id' => 2,
                'name' => 'RECEPCIO',
                'label' => 'Recepció',
            ],
            [
                'id' => 3,
                'name' => 'VARO',
                'label' => 'Váró',
            ],
            [
                'id' => 4,
                'name' => 'KOTOZO',
                'label' => 'Kötöző',
            ],
            [
                'id' => 5,
                'name' => 'MEGFIGYELO',
                'label' => 'Megfigyelő',
            ],
            [
                'id' => 6,
                'name' => 'MUTO',
                'label' => 'Műtó',
            ]
        ];

        OfficeType::insert($data);
    }
}
