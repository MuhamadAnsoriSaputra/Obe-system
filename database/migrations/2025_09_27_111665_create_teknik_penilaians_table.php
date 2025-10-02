<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teknik_penilaians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk', 20);
            $table->string('kode_angkatan', 20);
            $table->string('nama_penilaian');
            $table->decimal('bobot', 5, 2)->default(0);
            $table->timestamps();

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

    public function down(): void
    {
        Schema::dropIfExists('teknik_penilaians');
    }
};
