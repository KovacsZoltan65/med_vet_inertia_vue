<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id' => 1,
                'title' => 'user_access',
            ],
            [
                'id' => 2,
                'title' => 'task_access',
            ]
        ];

        Permission::insert($permissions);
    }
}
