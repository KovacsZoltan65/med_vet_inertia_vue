<?php

namespace Database\Seeders;

use Database\Factories\ClientFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fact = new ClientFactory();
        $fact->count(10)->create();
    }
}
