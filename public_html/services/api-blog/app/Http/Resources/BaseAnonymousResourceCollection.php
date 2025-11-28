<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Classe abstrata responsável por definir a base da coleção de recursos
 * 
 * @author David Guimarães
 */
class BaseAnonymousResourceCollection extends AnonymousResourceCollection {

  /**
   * Método responsável por gerar as informações da paginação
   * @param  Request $request
   * @param  array   $paginated
   * @param  array   $default
   * @return array
   */
  public function paginationInformation(Request $request, $paginated, $default): array {
    return [
      'pagination' => [
        'links' => $this->generateLinks($paginated),
        'info'  => $this->generateInformationPagination($paginated)
      ]
    ];
  }

  /**
   * Método responsável por gerar os links da paginação
   * @param  array   $paginated
   * @return array
   */
  protected function generateLinks($paginated): array {
    return [
      'first' => (string)($paginated['first_page_url'] ?? ''),
      'last'  => (string)($paginated['last_page_url']  ?? ''),
      'prev'  => (string)($paginated['prev_page_url']  ?? ''),
      'next'  => (string)($paginated['next_page_url']  ?? ''),
    ];
  }

  /**
   * Método responsável por gerar as informações da paginação
   * @param  array   $paginated Dados da paginação
   * @return array
   */
  protected function generateInformationPagination($paginated): array {
    return [
      'total'       => (int)($paginated['total']        ?? 0),
      'perPage'     => (int)($paginated['per_page']     ?? 0),
      'currentPage' => (int)($paginated['current_page'] ?? 0),
      'lastPage'    => (int)($paginated['last_page']    ?? 0),
      'from'        => (int)($paginated['from']         ?? 0),
      'to'          => (int)($paginated['to']           ?? 0),
    ];
  }
}