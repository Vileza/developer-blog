<?php

namespace App\Service\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Repository\Token\PersonalAccessTokenRepository;
use App\Service\Auth\Token\AuthTokenGenerationService;

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

  public function generateAuth(): string {
    $token = (new AuthTokenGenerationService($this->payloadAuthTokenDTO))->generate();
  }

  private function saveToken(string $token): void {
    $this->tokenRepository->create([
      'token' => $token,
      'type' => $this->payloadAuthTokenDTO->type,
      'expires_at' => now()->addMinutes(15),
    ]);
  }
}
