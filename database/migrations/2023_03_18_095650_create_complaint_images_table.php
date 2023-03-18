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
        Schema::create('complaint_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_images');
    }
};
