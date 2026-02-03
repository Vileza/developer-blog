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

  /**
   * Método responsável por verificar se um token existe pelas condições
   * @param  string $identifier Identificador
   * @param  string $type       Tipo de autenticação
   * @return bool
   */
  public function hasTokenByParameters(string $identifier, string $type): bool {
    return $this->generateQuery()->where('identifier', '=', $identifier)->where('type', '=', $type)->exists();
  }

  /**
   * Método responsável por registrar um token
   * @param  string $identifier Identificador
   * @param  string $token      Token de acesso
   * @param  string $type       Tipo de autenticação
   * @return Model
   */
  public function registerToken(string $identifier, string $token, string $type) {
    return $this->model::create([
      'identifier' => $identifier,
      'token'      => $token,
      'type'       => $type,
      'expires_at' => now()->addMinutes(15),
    ]);
  }
}