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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('rol_id')->default(7)->nullable()->comment('1 = alcalde, 2 = sindico, 3 = regidor, 4 = secretario de ayuntamiento, 5 = secretario técnico, 6 = administrador, 7 = visualizador');
            $table->foreign('rol_id')->references('rol_id')->on('rols');
            $table->unsignedBigInteger('party_id')->nullable();
            $table->foreign('party_id')->references('party_id')->on('parties');
            $table->integer('user_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
