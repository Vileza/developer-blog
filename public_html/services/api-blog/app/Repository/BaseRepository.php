<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Classe base para os repositórios dos modelos
 * 
 * @author David Guimarães
 */
abstract class BaseRepository {

  /**
   * Classe do modelo
   * @var string
   */
  protected $model;

  protected function generateQuery(): Builder {
    return app($this->model)->newQuery();
  }

  /**
   * Método responsável por buscar um registro pelo ID
   * @param  int $id Identificador
   * @return Model|null
   */
  public function findById(int $id){
    return $this->generateQuery()->find($id);
  }
}