<?php

namespace App\Service\Auth\Token;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use Firebase\JWT\JWT;

/**
 * Classe serviço responsável por gerar o token de autenticação
 * 
 * @author David Guimarães
 */
class AuthTokenGenerationService {

  /**
   * Payload de autenticação
   * @var PayloadAuthTokenDTO
   */
  private PayloadAuthTokenDTO $payloadAuthTokenDTO;

  /**
   * Método construtor
   * @param  PayloadAuthTokenDTO $obPayloadAuthTokenDTO Instância do DTO de payload de autenticação
   * @return void
   */
  public function __construct(PayloadAuthTokenDTO $obPayloadAuthTokenDTO) {
    $this->payloadAuthTokenDTO = $obPayloadAuthTokenDTO;
  }

  /**
   * Método responsável por gerar o token de autenticação
   * @return string
   */
  public function generate() {
    $tokenJWT = $this->generateTokenJWT();
    return $this->encrypt($tokenJWT);
  }

  /**
   * Método responsável por gerar o token JWT
   * @return string
   */
  private function generateTokenJWT(): string {
    return JWT::encode($this->payloadAuthTokenDTO->asArray(), env('APP_KEY'), 'HS256');
  }

  /**
   * Método responsável por criptografar o payload de autenticação
   * @return string
   */
  private function encrypt(string $tokenJWT): string {
    return encrypt($tokenJWT);
  }
}