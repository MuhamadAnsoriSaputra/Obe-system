<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim', 20)->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('kode_prodi', 20);
            $table->string('kode_angkatan', 20);
            $table->timestamps();

            $table->foreign('kode_prodi')
                ->references('kode_prodi')
                ->on('prodis')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('kode_angkatan')
                ->references('kode_angkatan')
                ->on('angkatans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
