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
        Schema::create('cpmk_mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cpmk', 20);        // FK ke CPMK
            $table->string('kode_mk', 20);          // FK ke Mata Kuliah
            $table->string('kode_angkatan', 20);    // FK ke Angkatan
            $table->decimal('bobot', 5, 2)->default(0); // persentase bobot CPMK utk MK
            $table->timestamps();

            $table->foreign('kode_cpmk')
                ->references('kode_cpmk')
                ->on('cpmks')
                ->cascadeOnDelete();

            $table->foreign('kode_mk')
                ->references('kode_mk')
                ->on('mata_kuliahs')
                ->cascadeOnDelete();

            $table->foreign('kode_angkatan')
                ->references('kode_angkatan')
                ->on('angkatans')
                ->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpmk_mata_kuliah');
    }
};
