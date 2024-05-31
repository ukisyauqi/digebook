<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('guests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->string('whatsapp');
      $table->string('qrcode_checkin');
      $table->string('qrcode_checkout');
      $table->timestamp('checkin_time')->nullable();
      $table->timestamp('checkout_time')->nullable();
      $table->enum('status', ['absent', 'present'])->default('absent');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('guests');
  }
};
