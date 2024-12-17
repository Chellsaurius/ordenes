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
        Schema::create('contents', function (Blueprint $table) {
            $table->id('content_id');
            $table->integer('content_number');
            $table->text('content_description');
            $table->text('content_document')->nullable();
            $table->text('content_documentPath')->nullable();
            $table->integer('content_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
