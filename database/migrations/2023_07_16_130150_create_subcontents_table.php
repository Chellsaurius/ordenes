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
        Schema::create('subcontents', function (Blueprint $table) {
            $table->id('subcontent_id');
            $table->integer('subcontent_number');
            $table->text('subcontent_description');
            $table->text('subcontent_document')->nullable();
            $table->text('subcontent_documentPath')->nullable();
            $table->integer('subcontent_status')->default('1')->comment('1 = activo, 2 = inactivo');
            $table->unsignedBigInteger('content_id')->nullable();
            $table->foreign('content_id')->references('content_id')->on('contents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcontents');
    }
};
