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
            $table->renameColumn('nip', 'niy');
            $table->string('gelar_depan')->nullable()->after('nama');
            $table->string('gelar_belakang')->nullable()->after('gelar_depan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->renameColumn('niy', 'nip');
            $table->dropColumn(['gelar_depan', 'gelar_belakang']);
        });
    }
};
