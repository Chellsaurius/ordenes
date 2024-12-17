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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id('certificate_id');
            $table->string('certificate_document');
            $table->string('certificate_documentPath');
            $table->date('certificate_date');
            $table->string('certificate_administration');
            $table->integer('certificate_status')->default(1)->comment('1 = activo, 2 = inactivo');
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
        Schema::dropIfExists('documents');
    }
};
