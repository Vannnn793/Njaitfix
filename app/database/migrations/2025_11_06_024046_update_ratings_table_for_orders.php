<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Tambah kolom order_id & photo_path
            if (!Schema::hasColumn('ratings', 'order_id')) {
                $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('ratings', 'photo_path')) {
                $table->string('photo_path')->nullable();
            }
        });

        // Tambah unique constraint baru (per order)
        Schema::table('ratings', function (Blueprint $table) {
            $table->unique(['order_id']);
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn(['order_id', 'photo_path']);
            $table->dropUnique(['order_id']);
        });
    }
};
