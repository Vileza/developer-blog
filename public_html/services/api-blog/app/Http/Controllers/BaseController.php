<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\ApiException;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Classe base responsável pela definição dos métodos de consulta de modelos
 * 
 * @author David Guimarães
 */
abstract class BaseController extends Controller {

  /**
   * Método responsável por buscar um registro pelo ID
   * @param  int $identificador Identificador do registro
   * @return BaseResource
   */
  public function searchModel($identificador): BaseResource {
    throw new ApiException(406, 'Registro não encontrado');
  }

  /**
   * Método responsável por buscar uma lista de registros
   * @return ResourceCollection
   */
  public function searchList(): ResourceCollection {
    throw new ApiException(406, 'Lista de registros não encontrada');
  }
}