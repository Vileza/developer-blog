<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Enums\Auth\AuthenticationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PayloadFormRequest;
use App\Http\Resource\Auth\AuthResource;
use App\Repository\Token\PersonalAccessTokenRepository;
use App\Service\Auth\AuthenticationManagement;
use App\Service\Auth\Token\AuthTokenGenerationService;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;

class AuthenticateController extends Controller {

  public function generateToken(PayloadFormRequest $request) {
    $obPayloadAuthTokenDTO      = PayloadAuthTokenDTO::fromArray($request->validated());
    $obAuthenticationManagement = new AuthenticationManagement(new PersonalAccessTokenRepository, $obPayloadAuthTokenDTO);

    $idToken = $obAuthenticationManagement->generateAuth();

    return (new AuthResource((new PersonalAccessTokenRepository)->findById($idToken)));
  }
}
