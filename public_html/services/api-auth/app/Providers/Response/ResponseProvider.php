<?php

namespace App\Providers\Response;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

/**
 * Classe provider responsável por configurar a resposta da API
 * 
 * @author David Guimarães
 */
class ResponseProvider extends ServiceProvider {

  /**
   * Método responsável por configurar o provider
   * @return void
   */
  public function boot(): void {
    JsonResource::withoutWrapping();
  }
}
