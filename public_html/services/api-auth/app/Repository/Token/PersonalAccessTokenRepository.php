<?php

namespace App\Repository\Token;

use App\Repository\BaseRepository;
use App\Models\Token\PersonalAccessToken;

/**
 * Classe repositório responsável pelas operações de banco de dados do modelo PersonalAccessToken
 * 
 * @author David Guimarães
 */
class PersonalAccessTokenRepository extends BaseRepository {

  /**
   * Classe do modelo
   * @var string
   */
  protected $model = PersonalAccessToken::class;

  /**
   * Método responsável por buscar um registro pelo ID
   * @param  int $id Identificador
   * @return Model|null
   */
  public function hasTokenById(int $id): bool {
    return $this->hasById($id);
  }
}