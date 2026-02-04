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
   * Método responsável por testar a geração do token de autenticação para usuário
   * @return void
   */
  public function testGenerateUserTokenSuccessfully(): void {
    $obPayloadDTO = PayloadAuthTokenDTO::fromArray([
      'identifier' => 1,
      'type'       => AuthenticationType::USER->value,
    ]);

    $token = (new AuthTokenGenerationService($obPayloadDTO))->generate();

    expect($token)->toBeString()->not->toBeEmpty();
    expect(explode('.', $token))->toHaveCount(1);

    $tokenJWT   = decrypt($token);
    $tokenParts = explode('.', $tokenJWT);

    $header = json_decode(base64_decode($tokenParts[0]), true);
    expect($header['alg'] ?? '')->toBe(env('JWT_ALGORITHM'));

    $payload = json_decode(base64_decode($tokenParts[1]), true);
    expect($payload['identifier'] ?? '')->toBeInt()->toBe($obPayloadDTO->identifier);
    expect($payload['type'] ?? '')->toBeString()->toBe($obPayloadDTO->type);
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

    $token = (new AuthTokenGenerationService($obPayloadDTO))->generate();

    expect($token)->toBeString()->not->toBeEmpty();
    expect(explode('.', $token))->toHaveCount(1);

    $tokenJWT   = decrypt($token);
    $tokenParts = explode('.', $tokenJWT);

    $header = json_decode(base64_decode($tokenParts[0]), true);
    expect($header['alg'] ?? '')->toBe(env('JWT_ALGORITHM'));

    $payload = json_decode(base64_decode($tokenParts[1]), true);
    expect($payload['identifier'] ?? '')->toBeInt()->toBe($obPayloadDTO->identifier);
    expect($payload['type'] ?? '')->toBeString()->toBe($obPayloadDTO->type);
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

    $primaryToken   = (new AuthTokenGenerationService($obPayloadDTO))->generate();
    $secondaryToken = (new AuthTokenGenerationService($obPayloadDTO))->generate();

    expect($primaryToken)->not->toBe($secondaryToken);
    expect(decrypt($primaryToken))->toBe(decrypt($secondaryToken));
  }
}