<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS `laravel_inertia_vue_crud`.`view_humans`;");
        DB::statement("CREATE VIEW `laravel_inertia_vue_crud`.`view_humans` AS 
            SELECT `h`.`id` AS `id`,
                   `h`.`name` AS `name`,
                   `h`.`type_id` AS `type_id`,
                   `h`.`image` AS `image`,
                   `h`.`created_at` AS `created_at`,
                   `h`.`updated_at` AS `updated_at` 
            FROM `laravel_inertia_vue_crud`.`humans` `h`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `laravel_inertia_vue_crud`.`view_humans`;");
    }
};
