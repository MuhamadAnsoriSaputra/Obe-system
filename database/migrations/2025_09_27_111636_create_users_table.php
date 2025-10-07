<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('google_id')->nullable();
            $table->string('password')->nullable();
            
            $table->string('kode_prodi', 20)->nullable();
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodis')->onDelete('set null');

            $table->string('role')->default('admin');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('foto')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
