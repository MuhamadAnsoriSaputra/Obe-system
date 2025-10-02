<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cpls', function (Blueprint $table) {
            $table->string('kode_cpl', 20)->primary();
            $table->string('kode_prodi', 20);
            $table->string('kode_angkatan', 20); // relasi ke angkatan/tahun ajaran
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('kode_prodi')
                ->references('kode_prodi')
                ->on('prodis')
                ->cascadeOnDelete();

            $table->foreign('kode_angkatan')
                ->references('kode_angkatan')
                ->on('angkatans')
                ->cascadeOnDelete();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('cpls');
    }
};
