<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Temporarily expand enum definition to include both 'petugas' and 'guru'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas', 'guru'])->default('guru')->change();
        });

        // 2. Update existing 'petugas' roles to 'guru' in the users table
        DB::table('users')->where('role', 'petugas')->update(['role' => 'guru']);

        // 3. Constrain the enum definition to only 'admin' and 'guru'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru'])->default('guru')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Temporarily expand enum definition back to include both 'petugas' and 'guru'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas', 'guru'])->default('petugas')->change();
        });

        // 2. Revert the roles from 'guru' back to 'petugas'
        DB::table('users')->where('role', 'guru')->update(['role' => 'petugas']);

        // 3. Constrain the enum definition back to only 'admin' and 'petugas'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas'])->default('petugas')->change();
        });
    }
};

