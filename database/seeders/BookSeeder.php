<?php

namespace Database\Seeders;

use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //\Illuminate\Support\Facades\DB::table('books')->truncate();
        
        $fact = new BookFactory();
        $fact->count(100)->create();
    }
}
