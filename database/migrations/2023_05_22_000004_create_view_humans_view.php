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
        DB::statement("CREATE VIEW `view_humans` AS select `h`.`id` AS `id`,`h`.`name` AS `name`,`h`.`type_id` AS `type_id`,`h`.`image` AS `image`,`h`.`created_at` AS `created_at`,`h`.`updated_at` AS `updated_at` from `laravel_inertia_vue_crud`.`humans` `h`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_humans`");
    }
};
