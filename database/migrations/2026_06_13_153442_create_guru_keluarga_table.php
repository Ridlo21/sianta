<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guru_keluarga', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->nullable()
                ->constrained('guru')
                ->nullOnDelete();

            $table->string('nama_ibu')->nullable();

            $table->string('nama_pasangan')->nullable();
            $table->string('pekerjaan_pasangan')->nullable();

            $table->string('kartu_pasangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_keluarga');
    }
};
