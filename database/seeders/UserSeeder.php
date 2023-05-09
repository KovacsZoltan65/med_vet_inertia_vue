<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate();
        
        //$fact = new UserFactory();
        \App\Models\User::create([
            'name' => 'Kovács Zoltán',
            'email' => 'zoltan1_kovacs@msn.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }
}