<?php

namespace App\Exceptions;

use App\Exceptions\Api\ApiException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * Classe responsável por lidar com as exceções da aplicação
 * 
 * @author David Guimarães
 */
class ExceptionHandler {

	/**
	 * Dados de lançamento da exceção
	 * @var Throwable
	 */
	private $exception;

	/**
	 * Dados da requisição
	 * @var Request
	 */
	private $request;

	/**
	 * Método responsável por instanciar a classe
	 * @param Throwable $exception
	 * @param Request $request
	 */
	public function __construct(Throwable $exception, Request $request) {
		$this->exception = $exception;
		$this->request   = $request;
	}

	/**
	 * Método responsável por lidar com as exceções da aplicação
	 * @return JsonResponse
	 */
	public function handle() {
		switch (get_class($this->exception)) {
			case NotFoundHttpException::class:
				return $this->generateModelNotFoundException();
			default:
				if($this->verifyCustomException()) return $this->generateCustomException();

				return $this->generateGenericException();
		}
	}

	/**
	 * Método responsável por verificar se a exceção é uma exceção customizada
	 * @return bool
	 */
	private function verifyCustomException() {
		$namespaceException = get_class($this->exception);

		if($namespaceException === self::class) return false;

		return (str_starts_with($namespaceException, 'App\\Exceptions\\'));
	}

	/**
	 * Método responsável por gerar uma exceção genérica
	 * @return JsonResponse
	 */
	private function generateGenericException() {
		$message = env('APP_DEBUG', false) ? $this->exception->getMessage() : 'Requisição inválida';

		return response()->json([
			'message' => $message
		], 400);
	}

	/**
	 * Método responsável por gerar uma exceção de modelo não encontrado
	 * @return JsonResponse
	 */
	private function generateModelNotFoundException() {
		$message = env('APP_DEBUG', false) ? $this->exception->getMessage() : 'Registro não encontrado';

		return response()->json([
			'message' => $message
		], 404);
	}

	/**
	 * Método responsável por gerar uma exceção customizada
	 * @return JsonResponse
	 */
	private function generateCustomException() {
		$httpCode = ($this->exception instanceof ApiException) ? $this->exception->getStatusCode() : 400;

		return response()->json([
			'message' => $this->exception->getMessage()
		], $httpCode);
	}
}
