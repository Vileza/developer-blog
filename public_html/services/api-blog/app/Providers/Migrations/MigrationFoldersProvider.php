<?php

namespace App\Providers\Migrations;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

/**
 * Classe provider responsável por carregar as migrações também das subpastas
 * 
 * @author David Guimarães
 */
class MigrationFoldersProvider extends ServiceProvider {

  /**
   * Bootstrap any application services.
   */
  public function boot(): void {
    //CARREGA O CAMINHO DA PASTA DE MIGRAÇÕES
    $migrationsPath = database_path('migrations');
        
    //BUSCA TODAS AS PASTAS E SUBPASTAS DENTRO DA PASTA DE MIGRAÇÕES
    $directories = File::isDirectory($migrationsPath) 
        ? File::directories($migrationsPath) 
        : [];
    
    //CRIA UM ARRAY COM O CAMINHO BASE E TODAS AS SUBPASTAS
    $paths = array_merge([$migrationsPath], $directories);
    
    //CARREGA AS MIGRAÇÕES DE TODOS OS CAMINHOS
    $this->loadMigrationsFrom($paths);
  }
}
