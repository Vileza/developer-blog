<?php

namespace Tests\Unit\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Enums\Auth\AuthenticationType;
use App\Service\Auth\Token\AuthTokenDecryptionService;
use App\Service\Auth\Token\AuthTokenGenerationService;
use Exception;
use Tests\TestCase;

/**
 * Classe responsável por testar a validação do payload de autenticação
 * @author David Guimarães
 */
class PayloadAuthTokenValidationTest extends TestCase {
  
  /**
   * Método teste responsável por validar se o token é válido
   * @return void
   */
  public function testValidateStructureTokenIsJWTValid(): void {
    $obPayloadDTO = PayloadAuthTokenDTO::fromArray([
      'identifier' => 1,
      'type'       => AuthenticationType::USER->value,
    ]);

    $token = (new AuthTokenGenerationService($obPayloadDTO))->generate();

    expect($token)->toBeString()->not->toBeEmpty();
    expect(explode('.', $token))->toHaveCount(1);

    $token = decrypt($token);

    expect($token)->toBeString()->not->toBeEmpty();

    $tokenComponents = explode('.', $token);

    expect($tokenComponents)->toBeArray()->toHaveCount(3);

    $header = json_decode(base64_decode($tokenComponents[0]), true);
    expect($header['alg'] ?? '')->toBe(env('JWT_ALGORITHM'));

    //VALIDA SE O PAYLOAD CORRESPONDE AO DTO CRIADO INICIALMENTE
    $payload = json_decode(base64_decode($tokenComponents[1]), true);
    expect($payload['identifier'] ?? '')->toBeInt()->toBe($obPayloadDTO->identifier);
    expect($payload['type'] ?? '')->toBeString()->toBe($obPayloadDTO->type);

    //VALIDA SE A ASSINATURA EXISTE
    expect($tokenComponents[2] ?? '')->toBeString()->not->toBeEmpty();
  }

  /**
   * Método teste responsável por validar se o token JWT é válido
   * @return void
   */
  public function testValidateTokenJWTIsValid(): void {
    $obPayloadDTO = PayloadAuthTokenDTO::fromArray([
      'identifier' => 1,
      'type'       => AuthenticationType::USER->value,
    ]);

    $token                 = (new AuthTokenGenerationService($obPayloadDTO))->generate();
    $obPayloadAuthTokenDTO = (new AuthTokenDecryptionService($token))->decrypt();

    expect($obPayloadAuthTokenDTO)->toBeInstanceOf(PayloadAuthTokenDTO::class);
    expect($obPayloadAuthTokenDTO->identifier)->toBeInt()->toBe($obPayloadDTO->identifier);
    expect($obPayloadAuthTokenDTO->type)->toBeString()->toBe($obPayloadDTO->type);
  }

  /**
   * Método teste responsável por validar se o token JWT é inválido
   * @return void
   */
  public function testValidateTokenJWTIsNotValid(): void {
    expect(fn() => (new AuthTokenDecryptionService('invalid-token'))->decrypt())->toThrow(Exception::class);
  }
}