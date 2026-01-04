<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\PayloadAuthTokenDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PayloadFormRequest;
use App\Service\Auth\AuthTokenGenerationService;

class AuthenticateController extends Controller {

  public function generateToken(PayloadFormRequest $request) {
    $obPayloadAuthTokenDTO        = PayloadAuthTokenDTO::fromArray($request->validated());
    $obAuthTokenGenerationService = new AuthTokenGenerationService($obPayloadAuthTokenDTO);

    $token = $obAuthTokenGenerationService->generate();
    dd($token);
  }
}
