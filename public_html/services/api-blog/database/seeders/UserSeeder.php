<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Classe seeder responsável por popular a tabela de usuários
 * 
 * @author David Guimarães
 */
class UserSeeder extends Seeder {

  /**
   * Método responsável por popular a tabela de usuários
   * @return void
   */
  public function run(): void {
    User::factory()->create([
      'name'  => 'Test User',
      'email' => 'test@example.com',
    ]);
  }
}
