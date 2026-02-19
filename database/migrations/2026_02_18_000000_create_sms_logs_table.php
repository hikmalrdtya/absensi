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
    Schema::create('sms_logs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('siswa_id')->nullable()->constrained('siswa')->nullOnDelete();
      $table->string('phone')->nullable();
      $table->text('message')->nullable();
      $table->string('status')->nullable();
      $table->text('response')->nullable();
      $table->text('error')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sms_logs');
  }
};
