<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('angkatans', function (Blueprint $table) {
            $table->string('kode_angkatan', 20)->primary();
            $table->string('kode_prodi', 20);
            $table->year('tahun');
            $table->boolean('aktif')->default(false);
            $table->timestamps();

            $table->foreign('kode_prodi')
                ->references('kode_prodi')
                ->on('prodis')
                ->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('angkatans');
    }
};
