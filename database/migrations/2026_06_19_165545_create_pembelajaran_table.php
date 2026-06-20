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
        Schema::create('pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained('rombel')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('guru')->onDelete('set null');
            $table->string('sk_mengajar', 255)->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->integer('jam_mengajar')->default(0);
            $table->tinyInteger('status_aktif')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelajaran');
    }
};
