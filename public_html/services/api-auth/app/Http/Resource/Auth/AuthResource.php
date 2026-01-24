<?php

namespace App\Http\Resource\Auth;

use App\Http\Resource\BaseResource;
use Illuminate\Http\Request;

/**
 * Classe resource responsável pela formatação dos dados do modelo Auth em uma resposta JSON
 * 
 * @author David Guimarães
 */
class AuthResource extends BaseResource {
  
  /**
   * Método responsável por transformar o recurso em um array
   * @param  Request $request
   * @return array
   */
  public function toArray(Request $request) {
    return [
      'token' => (string) $this->token
    ];
  }
}