<?php

namespace App\Service\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Repository\Token\PersonalAccessTokenRepository;
use App\Service\Auth\Token\AuthTokenGenerationService;

/**
 * Classe serviço responsável por gerenciar a autenticação
 * 
 * @author David Guimarães
 */
class AuthenticationManagement {
  
  /**
   * Payload de autenticação
   * @var PayloadAuthTokenDTO
   */
  private PayloadAuthTokenDTO $payloadAuthTokenDTO; 

  /**
   * Repositório de tokens de acesso
   * @var PersonalAccessTokenRepository
   */
  private PersonalAccessTokenRepository $tokenRepository;

  /**
   * Método construtor
   * @param  PayloadAuthTokenDTO $obPayloadAuthTokenDTO
   * @return void
   */
  public function __construct(PersonalAccessTokenRepository $obTokenRepository, PayloadAuthTokenDTO $obPayloadAuthTokenDTO) {
    $this->tokenRepository     = $obTokenRepository;
    $this->payloadAuthTokenDTO = $obPayloadAuthTokenDTO;
  }

  /**
   * Método responsável por gerar o token de autenticação
   * @return int
   */
  public function generateAuth(): int {
    $token = (new AuthTokenGenerationService($this->payloadAuthTokenDTO))->generate();
    return $this->saveToken($token);
  }

  /**
   * Método responsável por salvar o token de autenticação
   * @param  string $token Token de autenticação
   * @return int
   */
  private function saveToken(string $token): int {
    $identifier = $this->payloadAuthTokenDTO->identifier;
    $type       = $this->payloadAuthTokenDTO->type;

    $obPersonalAccessToken = $this->tokenRepository->registerToken($identifier, $token, $type);

    return ($obPersonalAccessToken && $obPersonalAccessToken->exists()) ? $obPersonalAccessToken->id : 0;
  }
}
