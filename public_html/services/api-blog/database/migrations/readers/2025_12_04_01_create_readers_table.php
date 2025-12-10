<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Método responsável por criar a tabela de leitores
   * @return void
   */
  public function up(): void {
    Schema::create('readers', function (Blueprint $table) {
      $table->id();
      $table->string('name')->fulltext();
      $table->string('email')->unique();
      $table->string('password')->nullable();
      $table->timestamps();
    });
  } 

  /**
   * Método responsável por dropar a tabela de leitores
   * @return void
   */
  public function down(): void {
    Schema::dropIfExists('readers');
  }
};
