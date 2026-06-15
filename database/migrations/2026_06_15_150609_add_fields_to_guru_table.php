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
            $table->string('nip')->nullable()->after('id');
            $table->string('nuptk')->nullable()->after('nip');
            $table->string('nik')->nullable()->after('nuptk');

            $table->string('nama')->nullable()->after('nik');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nama');

            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');

            $table->integer('agama_id')
                ->nullable()
                ->after('tanggal_lahir');

            $table->foreign('agama_id')
                ->references('id')
                ->on('agama')
                ->nullOnDelete();

            $table->string('status_perkawinan')->nullable()->after('agama_id');

            $table->text('alamat')->nullable()->after('status_perkawinan');

            $table->string('email')->nullable()->after('alamat');
            $table->string('no_hp')->nullable()->after('email');

            $table->string('foto')->nullable()->after('no_hp');

            $table->string('jenis_gtk')->nullable()->after('foto');
            $table->string('jabatan_gtk')->nullable()->after('jenis_gtk');
            $table->string('status_kepegawaian')->nullable()->after('jabatan_gtk');

            $table->string('jurusan')->nullable()->after('status_kepegawaian');

            $table->boolean('status_aktif')->nullable()->after('jurusan');

            $table->year('tahun_pensiun')->nullable()->after('status_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropForeign(['agama_id']);

            $table->dropColumn([
                'nip',
                'nuptk',
                'nik',
                'nama',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama_id',
                'status_perkawinan',
                'alamat',
                'email',
                'no_hp',
                'foto',
                'jenis_gtk',
                'jabatan_gtk',
                'status_kepegawaian',
                'jurusan',
                'status_aktif',
                'tahun_pensiun',
            ]);
        });
    }
};
