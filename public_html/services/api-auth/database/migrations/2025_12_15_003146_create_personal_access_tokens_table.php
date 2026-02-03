<?php

use App\Enums\Auth\AuthenticationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('personal_access_tokens', function (Blueprint $table) {
      $table->id();
      $table->string('identifier', 500)->index();
      $table->enum('type', array_column(AuthenticationType::cases(), 'value'))
            ->default(AuthenticationType::READER)
            ->index();
      $table->string('token', 1000)->unique()->index();
      $table->timestamp('expires_at')->nullable()->index();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('personal_access_tokens');
  }
};
