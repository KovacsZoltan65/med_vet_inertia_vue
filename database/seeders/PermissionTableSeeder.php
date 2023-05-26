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
        //\Illuminate\Support\Facades\DB::table('permissions')->truncate();
        
        $permissions = [
            ['id' => 1, 'title' => 'all'],
            ['id' => 2, 'title' => 'user_view'],
            ['id' => 3, 'title' => 'user_create'],
            ['id' => 4, 'title' => 'user_edit'],
            ['id' => 5, 'title' => 'user_delete'],
            ['id' => 6, 'title' => 'user_restore'],
            ['id' => 7, 'title' => 'company_view'],
            ['id' => 8, 'title' => 'company_create'],
            ['id' => 9, 'title' => 'company_edit'],
            ['id' => 10, 'title' => 'company_delete'],
            ['id' => 11, 'title' => 'company_restore'],
            ['id' => 12, 'title' => 'office_view'],
            ['id' => 13, 'title' => 'office_create'],
            ['id' => 14, 'title' => 'office_edit'],
            ['id' => 15, 'title' => 'office_delete'],
            ['id' => 16, 'title' => 'office_restore'],
            ['id' => 17, 'title' => 'address_view'],
            ['id' => 18, 'title' => 'address_create'],
            ['id' => 19, 'title' => 'address_edit'],
            ['id' => 20, 'title' => 'address_delete'],
            ['id' => 21, 'title' => 'address_restore'],
            
        ];

        Permission::insert($permissions);
    }
}
