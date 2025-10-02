<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hasil_obes', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->string('nim', 20);
            $table->string('kode_cpl', 20);
            $table->decimal('capaian_persentase', 5, 2);
            $table->timestamps();

            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswas')
                ->cascadeOnDelete();

            $table->foreign('kode_cpl')
                ->references('kode_cpl')
                ->on('cpls')
                ->cascadeOnDelete();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_obes');
    }
};
