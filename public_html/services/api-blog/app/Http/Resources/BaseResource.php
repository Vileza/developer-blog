<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Classe abstrata responsável por definir a base da resposta
 * 
 * @author David Guimarães
 */
abstract class BaseResource extends JsonResource {

  /**
   * Método responsável por instanciar a geração base da coleção de recursos
   * @param  mixed $resource Recurso
   * @return AnonymousResourceCollection
   */
  protected static function newCollection($resource) {
    return new BaseAnonymousResourceCollection($resource, static::class);
  }
}