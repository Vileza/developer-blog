<?php

namespace Tests\Feature\Auth;

use App\Enums\Auth\AuthenticationType;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * Classe responsável por testar a geração do token de autenticação
 * @author David Guimarães
 */
class AuthenticationGenerateTest extends TestCase {

  /**
   * Método responsável testar a validação do payload da requisição vazio
   * @return void
   */
  public function testValidatePayloadEmptyReturnInvalidRequest(): void {
    $response = $this->dispatchRequest([]);
    expect($response->status())->toBe(400);
  } 

  /**
   * Método responsável testar a validação do payload da requisição com tipo inválido
   * @return void
   */
  public function testValidatePayloadRequestWithInvalidTypeReturnInvalidRequest(): void {
    $payload  = ['identifier' => 'test-01', 'type' => 'random'];
    $response = $this->dispatchRequest($payload);

    expect($response->status())->toBe(400);
  }

  /**
   * Método responsável testar a validação do payload da requisição sem identificador
   * @return void
   */
  public function testValidatePayloadRequestWithoutIdentifierReturnInvalidRequest(): void {
    $payload  = ['type' => AuthenticationType::USER->value];
    $response = $this->dispatchRequest($payload);

    expect($response->status())->toBe(400);
  }

  /**
   * Método responsável testar a validação do payload da requisição sem tipo
   * @return void
   */
  public function testValidatePayloadRequestWithoutTypeReturnInvalidRequest(): void {
    $payload  = ['identifier' => 'test-01'];
    $response = $this->dispatchRequest($payload);

    expect($response->status())->toBe(400);
  }

  /**
   * Método responsável testar a validação do sucesso da geração do token de autenticação para usuário
   * @return void
   */
  public function testValidateUserTokenSuccessfullyReturnValidRequest(): void {
    $payload  = ['identifier' => 'test-01', 'type' => AuthenticationType::USER->value];
    $response = $this->dispatchRequest($payload);

    $this->validateTokenResponse($response);
  }

  /**
   * Método responsável testar a validação do sucesso da geração do token de autenticação para leitor
   * @return void
   */
  public function testValidateReaderTokenSuccessfullyReturnValidRequest(): void {
    $payload  = ['identifier' => 'test-01', 'type' => AuthenticationType::READER->value];
    $response = $this->dispatchRequest($payload);

    $this->validateTokenResponse($response);
  }

  /**
   * Método responsável testar a validação da resposta da requisição
   * @param  TestResponse $response Resposta da requisição
   * @return void
   */
  private function validateTokenResponse(TestResponse $response) {
    $response->assertStatus(200)->assertJsonStructure(['token']);

    $token = $response->json('token');

    expect($token)         ->toBeString()->not->toBeEmpty();
    expect(decrypt($token))->toBeString()->not->toBeEmpty();
  }

  /**
   * Método responsável pela disparada da requisição
   * @param  array $payload Payload da requisição
   * @return TestResponse
   */
  private function dispatchRequest(array $payload): TestResponse {
    return $this->post('/api', $payload);
  }
}