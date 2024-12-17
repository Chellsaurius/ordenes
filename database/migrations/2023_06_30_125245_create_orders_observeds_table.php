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
        Schema::create('orders_observeds', function (Blueprint $table) {
            $table->id('orderO_id');
            $table->integer('order_id')->nullable();
            $table->integer('comision_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->text('orderO_original')->nullable()->comment('asunto original de la orden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_observeds');
    }
};
