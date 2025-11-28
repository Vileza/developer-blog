<?php

namespace Database\Seeders\Content;

use App\Models\Content\Post;
use Illuminate\Database\Seeder;

/**
 * Classe seeder responsável por popular a tabela de posts
 * 
 * @author David Guimarães
 */
class PostSeeder extends Seeder {

  /**
   * Método responsável por popular a tabela de posts
   * @return void
   */
  public function run(): void {
    Post::factory()->count(100)->create();
  }
}
