<?php

namespace App\DTOs;

/**
 * Interface responsável por definir a estrutura base de um DTO
 * 
 * @author David Guimarães
 */
interface BaseStructureInterface {
  
  /**
   * Método responsável por criar um DTO a partir de um array
   * @param  array $data
   * @return self
   */
  public static function fromArray(array $data): self;
}
