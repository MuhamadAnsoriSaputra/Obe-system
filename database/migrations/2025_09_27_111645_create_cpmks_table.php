<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cpmks', function (Blueprint $table) {
            $table->string('kode_cpmk', 20)->primary();
            $table->string('kode_cpl', 20);   // FK ke CPL
            $table->string('kode_mk', 20);    // FK ke Mata Kuliah
            $table->text('deskripsi_cpmk');
            $table->timestamps();

            $table->foreign('kode_cpl')
                ->references('kode_cpl')
                ->on('cpls')
                ->cascadeOnDelete();

            $table->foreign('kode_mk')
                ->references('kode_mk')
                ->on('mata_kuliahs')
                ->cascadeOnDelete();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('cpmks');
    }
};
