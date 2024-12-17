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
        Schema::create('comision_observeds', function (Blueprint $table) {
            $table->id('observed_id');
            $table->integer('observed_comisionId')->nullable()->comment('para sacar la relación');
            $table->text('observed_original')->nullable()->comment('estado original del registro');
            $table->text('observed_movement')->nullable()->comment('actualización de la comisión');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comision_observeds');
    }
};
