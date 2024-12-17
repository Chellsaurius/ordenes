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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->dateTime('order_date');
            $table->text('order_document')->nullable();
            $table->text('order_documentPath')->nullable();
            $table->text('order_subject');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('type_id')->on('types');
            $table->integer('order_belongsTo')->comment('1 = comision, 2 = H ayuntamiento');
            $table->unsignedBigInteger('comision_id')->nullable();
            $table->foreign('comision_id')->references('comision_id')->on('comisions');
            $table->unsignedBigInteger('order_createdBy')->nullable();
            $table->foreign('order_createdBy')->references('id')->on('users');
            $table->integer('order_status')->default('1')->comment('1 = no publicado, 2 = revisión interna, 3 = abierta al publico, 4 = cancelado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
