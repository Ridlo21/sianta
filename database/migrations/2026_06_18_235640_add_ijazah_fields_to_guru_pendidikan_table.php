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
        Schema::table('guru_pendidikan', function (Blueprint $table) {
            $table->string('nomor_ijazah')->nullable()->after('tahun_lulus');
            $table->string('scan_file_ijazah')->nullable()->after('nomor_ijazah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru_pendidikan', function (Blueprint $table) {
            $table->dropColumn(['nomor_ijazah', 'scan_file_ijazah']);
        });
    }
};
