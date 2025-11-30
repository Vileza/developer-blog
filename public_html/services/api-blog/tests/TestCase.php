<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

/**
 * Classe base para os testes
 * 
 * @author David Guimarães
 */
abstract class TestCase extends BaseTestCase {

  /**
   * Método responsável por criar o banco de dados de teste
   * @return void
   */
  protected function setUp(): void {
    parent::setUp();

    //BUSCA O NOME DO BANCO DE DADOS NAS CONFIGURAÇÕES DE database.php
    $databaseName = config('database.connections.mysql.database');
    $connection   = DB::connection('mysql');

    //CRIA O BANCO DE DADOS SE NÃO EXISTIR
    $connection->getPdo()->exec("CREATE DATABASE IF NOT EXISTS `{$databaseName}`");

    //USA O BANCO DE DADOS CRIADO
    $connection->statement("USE `{$databaseName}`");
  }
}
