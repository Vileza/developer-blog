<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PayloadFormRequest;

class AuthenticateController extends Controller {

  public function generateToken(PayloadFormRequest $request) {
    $payload = $request->validated();

    dd($payload);
  }
}
