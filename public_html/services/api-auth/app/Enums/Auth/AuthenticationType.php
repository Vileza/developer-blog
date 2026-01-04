<?php

namespace App\Enums\Auth;

/**
 * Enum responsável por definir os tipos de autenticação
 * 
 * @author David Guimarães
 */
enum AuthenticationType: string {

  /**
   * Tipo de autenticação de usuário
   * @var string
   */
  case USER = 'user';

  /**
   * Tipo de autenticação de leitor
   * @var string
   */
  case READER = 'reader';

  /**
   * Método responsável por retornar os tipos de autenticação
   * @return string
   */
  public static function getEnums(): string {
    $labelEnums = [];
    foreach (self::cases() as $obEnum) $labelEnums[] = $obEnum->value;

    return implode('|', $labelEnums);
  }
}
