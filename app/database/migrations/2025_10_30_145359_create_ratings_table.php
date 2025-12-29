<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ratings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tailor_id')->constrained()->onDelete('cascade'); // penjahit yang dinilai
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user yang menilai
        $table->tinyInteger('rating')->comment('1-5'); // nilai bintang
        $table->text('comment')->nullable(); // komentar opsional
        $table->timestamps();

        $table->unique(['tailor_id', 'user_id']); // 1 user hanya bisa nilai 1 penjahit sekali
    });
}

};
