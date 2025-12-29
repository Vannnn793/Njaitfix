<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {

            // 1️⃣ Hapus foreign key di tailor_id
            $table->dropForeign('ratings_tailor_id_foreign');

            // 2️⃣ Hapus unique index lama
            $table->dropUnique('ratings_tailor_id_user_id_unique');

            // 3️⃣ Tambahkan foreign key kembali
            $table->foreign('tailor_id')
                ->references('id')
                ->on('tailors')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {

            // Kembalikan unique lama
            $table->unique(['tailor_id', 'user_id'], 'ratings_tailor_id_user_id_unique');

            // Kembalikan FK
            $table->foreign('tailor_id')
                ->references('id')
                ->on('tailors')
                ->onDelete('cascade');
        });
    }
};
