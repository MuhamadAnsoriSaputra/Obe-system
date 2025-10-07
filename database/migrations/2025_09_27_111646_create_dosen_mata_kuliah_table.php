<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dosen_mata_kuliah', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('kode_mk', 20);
            $table->string('nip', 20);
            $table->string('kode_angkatan', 20);
            $table->timestamps();

            $table->primary(['kode_mk', 'nip', 'kode_angkatan']);

            $table->foreign('kode_mk')
                ->references('kode_mk')
                ->on('mata_kuliahs')
                ->cascadeOnDelete();

            $table->foreign('nip')
                ->references('nip')
                ->on('dosens')
                ->cascadeOnDelete();

            $table->foreign('kode_angkatan')
                ->references('kode_angkatan')
                ->on('angkatans')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen_mata_kuliah');
    }
};
