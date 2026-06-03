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
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();

            $table->string('kode_nomenklatur', 10)->unique();
            $table->string('bidang_keahlian');
            $table->string('program_keahlian');
            $table->string('konsentrasi_keahlian');

            $table->text('deskripsi')->nullable();

            $table->string('foto')->nullable();

            $table->enum('status', [
                'Aktif',
                'Nonaktif'
            ])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
