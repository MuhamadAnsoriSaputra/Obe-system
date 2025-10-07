<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->string('nip', 20)->primary();
            $table->unsignedBigInteger('id_user');
            $table->string('nama');
            $table->string('gelar')->nullable();
            $table->string('jabatan')->nullable(); 
            $table->string('kode_prodi');      
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('kode_prodi')
                ->references('kode_prodi')
                ->on('prodis')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
