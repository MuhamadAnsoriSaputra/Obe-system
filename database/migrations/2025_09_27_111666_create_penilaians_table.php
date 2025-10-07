<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20);
            $table->string('kode_mk', 20);
            $table->string('kode_angkatan', 20);
            $table->decimal('nilai', 5, 2)->default(0); // nilai akhir MK
            $table->timestamps();

            // Relasi ke mahasiswa
            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswas')
                ->cascadeOnDelete();

            // Relasi ke mata kuliah
            $table->foreign('kode_mk')
                ->references('kode_mk')
                ->on('mata_kuliahs')
                ->cascadeOnDelete();

            // Relasi ke angkatan
            $table->foreign('kode_angkatan')
                ->references('kode_angkatan')
                ->on('angkatans')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
