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
            $table->string('status_kepegawaian')->nullable()->after('jabatan_gtk');
            $table->string('sk_pengangkatan')->nullable()->after('status_kepegawaian');
            $table->date('tmt_pengangkatan')->nullable()->after('sk_pengangkatan');
            $table->string('lembaga_pengangkat')->nullable()->after('tmt_pengangkatan');
            $table->string('npwp', 30)->nullable()->after('lembaga_pengangkat');
            $table->string('nama_wajib_pajak')->nullable()->after('npwp');
            $table->boolean('sekolah_induk')->default(true)->after('nama_wajib_pajak');
            $table->boolean('status_kuliah')->default(false)->after('sekolah_induk');
            $table->string('no_surat_tugas')->nullable()->after('status_kuliah');
            $table->date('tgl_surat_tugas')->nullable()->after('no_surat_tugas');
        });

        Schema::table('guru_keluarga', function (Blueprint $table) {
            $table->string('kartu_pasangan')->nullable()->after('pekerjaan_pasangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn([
                'status_kepegawaian',
                'sk_pengangkatan',
                'tmt_pengangkatan',
                'lembaga_pengangkat',
                'npwp',
                'nama_wajib_pajak',
                'sekolah_induk',
                'status_kuliah',
                'no_surat_tugas',
                'tgl_surat_tugas',
            ]);
        });

        Schema::table('guru_keluarga', function (Blueprint $table) {
            $table->dropColumn('kartu_pasangan');
        });
    }
};
