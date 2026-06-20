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
        Schema::create('wali_rombel', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rombel_id')
                ->constrained('rombel')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedBigInteger('guru_id');

            $table->foreign('guru_id')
                ->references('id')
                ->on('guru')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_rombel');
    }
};
