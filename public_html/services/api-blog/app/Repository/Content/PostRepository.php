<?php

namespace App\Repository\Content;

use App\Repository\BaseRepository;
use App\Models\Content\Post;

/**
 * Classe repositório responsável pelas operações de banco de dados do modelo Post
 * 
 * @author David Guimarães
 */
class PostRepository extends BaseRepository {

  /**
   * Classe do modelo
   * @var string
   */
  protected $model = Post::class;

  /**
   * Método responsável por buscar um registro pelo ID
   * @param  int $id Identificador
   * @return Model|null
   */
  public function getPostById(int $id): ?Post {
    return $this->findById($id);
  }
}