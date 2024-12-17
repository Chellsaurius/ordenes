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
        Schema::create('pendings', function (Blueprint $table) {
            $table->id('pending_id');
            $table->text('pending_description');
            $table->text('pending_document')->nullable();
            $table->text('pending_documentPath')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->unsignedBigInteger('content_id')->nullable();
            $table->foreign('content_id')->references('content_id')->on('contents');
            $table->unsignedBigInteger('standing_id')->nullable();
            $table->foreign('standing_id')->references('standing_id')->on('standings');
            $table->integer('pending_status')->default(1)->comment('1 = activo, 2 = inactivo');
            $table->string('pending_standing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendings');
    }
};
