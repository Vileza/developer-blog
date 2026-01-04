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

  /**
   * Método responsável por gerar a query do modelo
   * @return Builder
   */
  protected function generateQuery(): Builder {
    return app($this->model)->newQuery();
  }

  /**
   * Método responsável por verificar se um registro existe pelo ID
   * @param  int $id Identificador
   * @return bool
   */
  protected function hasById(int $id): bool {
    return $this->generateQuery()->where('id', '=', $id)->exists();
  }

  /**
   * Método responsável por criar um registro
   * @param  array $data
   * @return 
   */
  public function create(array $data) {
    return $this->model::create($data);
  }
}