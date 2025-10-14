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
            $table->string('kode_cpl', 20)->nullable();   // tambah: relasi ke CPL
            $table->string('kode_cpmk', 20)->nullable();  // tambah: relasi ke CPMK
            $table->string('kode_angkatan', 20);
            $table->decimal('skor_maks', 8, 2)->default(0);          // tambah: skor maks
            $table->decimal('nilai_perkuliahan', 8, 2)->nullable();  // tambah: nilai aktual
            $table->decimal('nilai', 8, 2)->nullable();               // nilai akhir mk (opsional)
            $table->timestamps();

            // relasi mahasiswa
            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswas')
                ->cascadeOnDelete();

            // relasi mata kuliah
            $table->foreign('kode_mk')
                ->references('kode_mk')
                ->on('mata_kuliahs')
                ->cascadeOnDelete();

            // relasi cpl
            $table->foreign('kode_cpl')
                ->references('kode_cpl')
                ->on('cpls')
                ->nullOnDelete();

            // relasi cpmk
            $table->foreign('kode_cpmk')
                ->references('kode_cpmk')
                ->on('cpmks')
                ->nullOnDelete();

            // relasi angkatan
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
