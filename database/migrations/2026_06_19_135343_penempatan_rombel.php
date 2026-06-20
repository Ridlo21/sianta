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
        Schema::create('penempatan_rombel', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rombel_id')
                ->constrained('rombel')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('siswa_id');

            $table->foreign('siswa_id')
                ->references('id_person')
                ->on('siswa')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->boolean('status_aktif')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penempatan_rombel');
    }
};
