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
        Schema::table('guru', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('no_hp');
            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->nullOnDelete();

            $table->string('scan_kk')->nullable()->after('foto');
            $table->string('scan_akta')->nullable()->after('scan_kk');
            $table->string('scan_ktp')->nullable()->after('scan_akta');
            $table->string('scan_sk')->nullable()->after('scan_ktp');
            $table->string('scan_transkrip_nilai')->nullable()->after('scan_sk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);

            $table->dropColumn([
                'jurusan_id',
                'scan_kk',
                'scan_akta',
                'scan_ktp',
                'scan_sk',
                'scan_transkrip_nilai',
            ]);
        });
    }
};
