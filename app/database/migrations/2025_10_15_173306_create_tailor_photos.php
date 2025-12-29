<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_tailor_photos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tailor_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('path'); // menyimpan path file
            $table->timestamps();
            $table->integer('extra_price')->nullable();
            $table->unsignedBigInteger('tailor_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tailor_photos');
    }
};
