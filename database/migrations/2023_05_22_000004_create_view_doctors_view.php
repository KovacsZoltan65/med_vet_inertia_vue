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
        DB::statement("CREATE VIEW `view_doctors` AS select `laravel_inertia_vue_crud`.`humans`.`id` AS `id`,`laravel_inertia_vue_crud`.`humans`.`name` AS `name`,`laravel_inertia_vue_crud`.`humans`.`type_id` AS `type_id`,`laravel_inertia_vue_crud`.`humans`.`image` AS `image`,`laravel_inertia_vue_crud`.`humans`.`created_at` AS `created_at`,`laravel_inertia_vue_crud`.`humans`.`updated_at` AS `updated_at` from `laravel_inertia_vue_crud`.`humans` where `laravel_inertia_vue_crud`.`humans`.`type_id` = 3");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_doctors`");
    }
};
