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
        Schema::create('records_observeds', function (Blueprint $table) {
            $table->id('recordO_id'); 
            $table->integer('comision_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('position_id')->nullable();
            $table->text('recordO_original')->nullable()->comment('estado original del registro');
            $table->text('recordO_disenable')->nullable()->comment('actualización el status');
            $table->text('recordO_movement')->nullable()->comment('actualización del registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records_observeds');
    }
};
