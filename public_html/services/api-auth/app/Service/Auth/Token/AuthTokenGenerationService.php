<?php

namespace App\Service\Auth\Token;

use App\DTOs\Auth\PayloadAuthTokenDTO;

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
   * @param  PayloadAuthTokenDTO $obPayloadAuthTokenDTO
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
    return $this->encryptPayload();
  }

  /**
   * Método responsável por criptografar o payload de autenticação
   * @return string
   */
  private function encryptPayload(): string {
    return encrypt(json_encode($this->payloadAuthTokenDTO));
  }
}