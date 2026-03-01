<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PayloadFormRequest;
use App\Http\Resource\Auth\AuthResource;
use App\Repository\Token\PersonalAccessTokenRepository;
use App\Service\Auth\AuthenticationGenerationManagement;
use Illuminate\Support\Facades\Cache;

/**
 * Classe controlador responsável pela autenticação
 * @author David Guimarães
 */
class AuthenticateController extends Controller {

  /**
   * Método responsável por gerar o token de autenticação
   * @param  PayloadFormRequest $request
   * @return AuthResource
   */
  public function generateToken(PayloadFormRequest $request) {
    $token = Cache::remember('authentication:token:generate', 60, function () use ($request){
      $obPayloadAuthTokenDTO      = PayloadAuthTokenDTO::fromArray($request->validated());
      $obAuthenticationManagement = new AuthenticationGenerationManagement(new PersonalAccessTokenRepository, $obPayloadAuthTokenDTO);

      $idToken = $obAuthenticationManagement->generateAuth();

      return (new AuthResource((new PersonalAccessTokenRepository)->findById($idToken)));
    });
    return $token;
  }
}
