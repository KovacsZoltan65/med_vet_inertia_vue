<?php

namespace Database\Seeders;

use App\Models\AddressType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                   'id' => 1,
                 'name' => 'POST',
                'label' => 'Post',
            ],
            [
                   'id' => 2,
                 'name' => 'CENTER',
                'label' => 'Center',
            ],
            [
                   'id' => 3,
                 'name' => 'STORE',
                'label' => 'Store',
            ],
        ];

        AddressType::insert($data);
    }
}
