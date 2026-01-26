<?php

namespace Tests\Unit\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Enums\Auth\AuthenticationType;
use App\Service\Auth\Token\AuthTokenGenerationService;
use Tests\TestCase;

/**
 * Classe responsável por testar a geração do token de autenticação
 * @author David Guimarães
 */
class GenerateTokenTest extends TestCase {
  
  /**
   * Método responsável por testar a validação do payload decriptado
   * @return void
   */
  public function testValidadePayloadDecrypted(): void {
    $obPayloadDTO = PayloadAuthTokenDTO::fromArray([
      'identifier' => 1,
      'type'       => AuthenticationType::USER->value,
    ]);

    $token = (new AuthTokenGenerationService($obPayloadDTO))->generate();
    $token = decrypt($token);
    $tokenPayload = json_decode($token, true);

    expect($token)->toBeString()->not->toBeEmpty();
    expect($tokenPayload)->toBeArray()->not->toBeEmpty();
    expect($tokenPayload['identifier'] ?? null)->toBeInt()->toBe($obPayloadDTO->identifier);
    expect($tokenPayload['type'] ?? null)->toBeString()->toBe($obPayloadDTO->type);
  }

  /**
   * Método responsável por testar a geração do token de autenticação para usuário
   * @return void
   */
  public function testGenerateUserTokenSuccessfully(): void {
    $obPayloadDTO = PayloadAuthTokenDTO::fromArray([
      'identifier' => 1,
      'type'       => AuthenticationType::USER->value,
    ]);

    $token        = (new AuthTokenGenerationService($obPayloadDTO))->generate();
    $token        = decrypt($token);
    $tokenPayload = json_decode($token, true);

    expect($token)->toBeString()->not->toBeEmpty();
    expect($tokenPayload)->toBeArray()->not->toBeEmpty();
    expect($tokenPayload['type'] ?? null)->toBeString()->toBe(AuthenticationType::USER->value);
  }

  /**
   * Método responsável por testar a geração do token de autenticação para leitor
   * @return void
   */
  public function testGenerateReaderTokenSuccessfully(): void {
    $obPayloadDTO = PayloadAuthTokenDTO::fromArray([
      'identifier' => 1,
      'type'       => AuthenticationType::READER->value,
    ]);

    $token        = (new AuthTokenGenerationService($obPayloadDTO))->generate();
    $token        = decrypt($token);
    $tokenPayload = json_decode($token, true);

    expect($token)->toBeString()->not->toBeEmpty();
    expect($tokenPayload)->toBeArray()->not->toBeEmpty();
    expect($tokenPayload['type'] ?? null)->toBeString()->toBe(AuthenticationType::READER->value);
  }

  /**
   * Método responsável por testar a geração de tokens diferentes para payloads iguais
   * @return void
   */
  public function testTokenIsNotSameForPayloadEquals(): void {
    $obPayloadDTO = PayloadAuthTokenDTO::fromArray([
      'identifier' => 1,
      'type'       => AuthenticationType::USER->value,
    ]);

    $primaryToken = (new AuthTokenGenerationService($obPayloadDTO))->generate();
    $secondaryToken = (new AuthTokenGenerationService($obPayloadDTO))->generate();

    expect($primaryToken)->not->toBe($secondaryToken);
    expect(decrypt($primaryToken))->toBe(decrypt($secondaryToken));
  }
}