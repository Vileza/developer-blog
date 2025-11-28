<?php

namespace Database\Seeders;

use Database\Seeders\Content\PostSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Classe seeder responsável por executar os seeders de todos os serviços
 * 
 * @author David Guimarães
 */
class DatabaseSeeder extends Seeder {
  use WithoutModelEvents;

  /**
   * Método responsável por executar os seeders de todos os serviços
   * @return void
   */
  public function run(): void {
    $this->call([
      UserSeeder::class,
      PostSeeder::class,
    ]);
  }
}
