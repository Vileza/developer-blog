<?php

namespace App\Service\Auth\Token;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

/**
 * Classe serviço responsável por decriptar o token de autenticação
 * 
 * @author David Guimarães
 */
class AuthTokenDecryptionService {

  /**
   * Token de autenticação
   * @var string
   */
  private string $token;

  /**
   * Método construtor
   * @param  string $token
   * @return void
   */
  public function __construct(string $token) {
    $this->token = decrypt($token);
  }

  /**
   * Método responsável por decriptar o token de autenticação
   * @return ?PayloadAuthTokenDTO
   */
  public function decrypt(): ?PayloadAuthTokenDTO {
    return $this->generatePayloadAuthTokenDTO($this->decodeToken());
  }

  /**
   * Método responsável por decodificar o token de autenticação
   * @return stdClass
   */
  private function decodeToken() {
    $payload = JWT::decode($this->token, new Key(env('APP_KEY'), env('JWT_ALGORITHM')));
    return ($payload instanceof stdClass) ? $payload : new stdClass;
  }

  /**
   * Método responsável por gerar o payload de autenticação
   * @param  stdClass $payload
   * @return ?PayloadAuthTokenDTO
   */
  private function generatePayloadAuthTokenDTO(stdClass $payload): ?PayloadAuthTokenDTO {
    if(!property_exists($payload, 'identifier') || !property_exists($payload, 'type')) return null;

    return PayloadAuthTokenDTO::fromArray([
      'identifier' => $payload->identifier,
      'type'       => $payload->type,
    ]);
  }
}