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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            
            $table->integer('company_id')->comment('Cég azonosító');
            $table->integer('human_id')->comment('Személy azonosító');
            $table->integer('type_id')->comment('Cím típusa');
            $table->string('city')->comment('Város');
            $table->string('address')->comment('Cím');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
