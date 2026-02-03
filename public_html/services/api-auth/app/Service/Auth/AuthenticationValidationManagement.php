<?php

namespace App\Service\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Repository\Token\PersonalAccessTokenRepository;
use App\Service\Auth\Token\AuthTokenDecryptionService;

/**
 * Classe serviço responsável por gerenciar a autenticação
 * 
 * @author David Guimarães
 */
class AuthenticationValidationManagement {
  
  /**
   * Token de autenticação
   * @var string
   */
  private string $token; 

  /**
   * Repositório de tokens de acesso
   * @var PersonalAccessTokenRepository
   */
  private PersonalAccessTokenRepository $tokenRepository;

  /**
   * Método construtor
   * @param  PersonalAccessTokenRepository $obTokenRepository Instância do repositório de tokens de acesso
   * @param  string                        $token             Token de autenticação
   * @return void
   */
  public function __construct(PersonalAccessTokenRepository $obTokenRepository, string $token) {
    $this->tokenRepository = $obTokenRepository;
    $this->token           = $token;
  }

  /**
   * Método responsável por validar o token de autenticação
   * @return bool
   */
  public function validateToken(): bool {
    $obPayloadAuthTokenDTO = (new AuthTokenDecryptionService($this->token))->decrypt();
    return $this->validateTokenExists($obPayloadAuthTokenDTO);
  }

  /**
   * Método responsável por verificar se o token de autenticação existe
   * @param  PayloadAuthTokenDTO $obPayloadAuthTokenDTO Payload de autenticação
   * @return bool
   */
  private function validateTokenExists(PayloadAuthTokenDTO $obPayloadAuthTokenDTO): bool {
    $identifier = $obPayloadAuthTokenDTO->identifier;
    $type       = $obPayloadAuthTokenDTO->type;

    $hasToken = $this->tokenRepository->hasTokenByParameters($identifier, $type);

    return (is_bool($hasToken)) ? $hasToken : false;
  }
}
