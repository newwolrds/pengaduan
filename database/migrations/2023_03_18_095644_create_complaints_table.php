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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->comments('Pengadu');
            $table->foreignId('responded_by')->nullable()->references('id')->on('users')->onDelete('cascade')->comments('Yang Menanggapi');
            $table->string('title');
            $table->longText('description');
            $table->string('link_video')->nullable();
            $table->date('date');
            $table->enum('level', ['rendah', 'sedang', 'tinggi']);
            $table->enum('status', ['PENDING', 'PROCESS', 'REJECTED', 'DONE']);
            $table->enum('status_pengaduan', ['belum_selesai','selesai'])->default('belum_selesai');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
