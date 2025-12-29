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
        Schema::create('tailors', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id'); // tambahkan kolom user_id dulu
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // baru definisikan foreign key
    $table->string('nama')->nullable();
    $table->string('skill')->nullable();
    $table->string('umur')->nullable();
    $table->string('alamat')->nullable();
    $table->string('no_hp')->nullable();
    $table->text('deskripsi')->nullable();
    $table->string('harga')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tailors');
    }
};
