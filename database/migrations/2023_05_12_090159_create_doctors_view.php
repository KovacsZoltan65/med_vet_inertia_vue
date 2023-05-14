<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement($this->dropView());
    }
    
    public function createView(): string
    {
        return "CREATE DEFINER = 'root'@'localhost' VIEW laravel_inertia_vue_crud.view_doctors AS
            SELECT
              `humans`.`id` AS `id`,
              `humans`.`name` AS `name`,
              `humans`.`type_id` AS `type_id`,
              `humans`.`image` AS `image`,
              `humans`.`created_at` AS `created_at`,
              `humans`.`updated_at` AS `updated_at`
            FROM `humans`
            WHERE `humans`.`type_id` = 3;";
    }
    
    private function dropView(): string
    {
        return "DROP VIEW IF EXISTS `view_doctors`;";
    }
};
