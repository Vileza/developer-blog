<?php

namespace App\DTOs\Auth;

use App\DTOs\BaseStructureInterface;

/**
 * DTO responsável por representar o payload de autenticação
 * 
 * @author David Guimarães
 */
class PayloadAuthTokenDTO implements BaseStructureInterface {

  /**
   * Identificador do usuário ou leitor
   * @var int
   */
  public int $identifier;

  /**
   * Tipo de autenticação
   * @var string
   */
  public string $type;

  /**
   * Método responsável por converter o DTO em um array
   * @return array
   */
  public function asArray(): array {
    return [
      'identifier' => $this->identifier,
      'type'       => $this->type,
    ];
  }

  /**
   * Método responsável por criar um DTO a partir de um array
   * @param  array $data
   * @return self
   */
  public static function fromArray(array $data): self {
    $obPayloadDTO             = new self();
    $obPayloadDTO->identifier = (int)    ($data['identifier'] ?? 0);
    $obPayloadDTO->type       = (string) ($data['type']       ?? '');

    return $obPayloadDTO;
  }
}
