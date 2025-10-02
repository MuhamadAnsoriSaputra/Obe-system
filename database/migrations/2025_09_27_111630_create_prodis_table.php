<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prodis', function (Blueprint $table) {
            $table->string('kode_prodi', 20)->primary();
            $table->string('nama_prodi');
            $table->string('jenjang');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('prodis');
    }
};
