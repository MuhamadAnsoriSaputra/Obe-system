<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20);
            $table->unsignedBigInteger('teknik_id');
            $table->decimal('nilai', 5, 2)->default(0);
            $table->timestamps();

            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswas')
                ->cascadeOnDelete();

            $table->foreign('teknik_id')
                ->references('id')
                ->on('teknik_penilaians')
                ->cascadeOnDelete();
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
