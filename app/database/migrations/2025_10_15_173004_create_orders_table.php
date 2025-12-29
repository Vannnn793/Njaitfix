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
            $table->id();
            $table->unsignedBigInteger('user_id'); // tambahkan kolom user_id dulu
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // baru definisikan foreign key
            $table->string('nama');
            $table->string('jumlah');
            $table->string('ukuran');
            $table->string('deskripsi');
            $table->string('design');
            $table->string('harga');
            $table->text('tambahan')->nullable();
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
