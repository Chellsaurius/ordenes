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
        Schema::create('parties', function (Blueprint $table) {
            $table->id('party_id');
            $table->string('party_name');
            $table->string('party_acronim')->nullable();
            $table->string('party_colour');
            $table->string('party_icon')->nullable();
            $table->string('party_iconPath')->nullable();
            $table->integer('party_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
