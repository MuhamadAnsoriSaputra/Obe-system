<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bobot_kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk', 20);
            $table->decimal('bobot', 5, 2)->default(1); // contoh: 0.25
            $table->timestamps();

            $table->foreign('kode_mk')
                      ->references('kode_mk')
                ->on('mata_kuliahs')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_kriterias');
    }
};
