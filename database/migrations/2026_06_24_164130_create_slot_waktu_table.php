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
        Schema::create('slot_waktu', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['Sabtu', 'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis']);
            $table->integer('jam_ke');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->boolean('is_istirahat')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_waktu');
    }
};
