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
        Schema::create('guru_penugasan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->nullable()
                ->constrained('guru')
                ->cascadeOnDelete();

            $table->string('nomor_surat_tugas')->nullable();

            $table->date('tanggal_surat_tugas')->nullable();

            $table->string('tahun_ajaran')->nullable();

            $table->string('sekolah_induk')->nullable();

            $table->string('sk_pengangkatan')->nullable();

            $table->date('tmt_pengangkatan')->nullable();

            $table->string('lembaga_pengangkat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_penugasan');
    }
};
