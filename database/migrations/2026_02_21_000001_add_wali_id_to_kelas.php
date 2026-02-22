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
    Schema::table('kelas', function (Blueprint $table) {
      if (! Schema::hasColumn('kelas', 'wali_id')) {
        $table->foreignId('wali_id')->nullable()->constrained('users')->nullOnDelete()->after('nama_kelas');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('kelas', function (Blueprint $table) {
      if (Schema::hasColumn('kelas', 'wali_id')) {
        $table->dropConstrainedForeignId('wali_id');
      }
    });
  }
};
