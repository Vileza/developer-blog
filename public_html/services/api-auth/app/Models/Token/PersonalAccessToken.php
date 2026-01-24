<?php

namespace App\Models\Token;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe modelo responsável por representar o token de acesso pessoal
 * 
 * @author David Guimarães
 */
class PersonalAccessToken extends Model {

  /**
   * Atributos que devem ser ignoradas 
   * @var string[]
   */
  protected $guarded = [
    'id', 
    'created_at', 
    'updated_at'
  ];
}
