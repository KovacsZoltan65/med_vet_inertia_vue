<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('rögzítette');
            $table->integer('doctor_id')->comment('orvos azonosító');
            $table->integer('animal_id')->comment('állat azonosító');
            $table->integer('office_id')->comment('helyiség azonosító');
            $table->integer('treatment_id')->comment('kezelés azonosító');
            $table->timestamp('start_time')->useCurrentOnUpdate()->useCurrent()->comment('kezelés kezdete');
            $table->timestamp('final_time')->nullable()->comment('kezelés vége');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
