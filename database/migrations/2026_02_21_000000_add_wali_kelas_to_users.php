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
    // add new enum value 'wali_kelas' to role column
    DB::statement("ALTER TABLE users MODIFY role ENUM('admin','petugas','wali_kelas') NOT NULL DEFAULT 'petugas'");

    Schema::table('users', function (Blueprint $table) {
      if (! Schema::hasColumn('users', 'kelas_id')) {
        $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete()->unique()->after('role');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      if (Schema::hasColumn('users', 'kelas_id')) {
        $table->dropUnique(['kelas_id']);
        $table->dropConstrainedForeignId('kelas_id');
      }
    });

    // revert role enum (remove wali_kelas)
    DB::statement("ALTER TABLE users MODIFY role ENUM('admin','petugas') NOT NULL DEFAULT 'petugas'");
  }
};
