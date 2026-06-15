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
        Schema::create('guru_pendidikan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->nullable()
                ->constrained('guru')
                ->cascadeOnDelete();

            $table->string('jenjang')->nullable();
            $table->string('jurusan')->nullable();

            $table->string('nama_instansi')->nullable();

            $table->year('tahun_masuk')->nullable();
            $table->year('tahun_lulus')->nullable();

            $table->boolean('pendidikan_terakhir')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_pendidikan');
    }
};
