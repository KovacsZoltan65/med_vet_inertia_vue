<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //DB::table('users')->truncate();
        /*
        \App\Models\User::create([
            'name' => 'Kovács Zoltán',
            'email' => 'zoltan1_kovacs@msn.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
        */
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'User',
                'email'          => 'user@user.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
        ];

        \App\Models\User::insert($users);
    }
}