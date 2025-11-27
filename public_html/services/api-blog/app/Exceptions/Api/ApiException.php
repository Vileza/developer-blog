<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Classe responsável por lançar exceções de API
 * 
 * @author David Guimarães
 */
class ApiException extends HttpException {

  /**
   * Método responsável por instanciar a classe
   * @param int        $httpCode  Código HTTP
   * @param string     $message   Mensagem da exceção
   * @param \Throwable $previous  Exceção anterior
   * @param array      $headers   Cabeçalhos da exceção
   */
  public function __construct(int $httpCode = 404, string $message = '', ?\Throwable $previous = null, array $headers = []) {
    parent::__construct($httpCode, $message, $previous, $headers, $httpCode);
  }
}
