<?php

use App\Http\Controllers\Content\PostController;
use App\Models\Content\Post;
use Illuminate\Http\Resources\Json\ResourceCollection;

describe('PostController::searchList', function() {

  it('Retornar uma lista paginada de posts', function(){
    Post::factory()->count(10)->create();

    $obResourceCollection = (new PostController)->searchList();

    expect($obResourceCollection)->toBeInstanceOf(ResourceCollection::class);

    $responseCollection = $obResourceCollection->response()->getData(true);

    //VERIFICA A QUANTIDADE DE REGISTROS RETORNADOS
    expect($responseCollection['data'])->toHaveCount(10);

    //VERIFICA A PAGINAÇÃO
    expect($responseCollection['pagination'])->toBeArray();
    expect($responseCollection['pagination']['links'])->toBeArray();
    expect($responseCollection['pagination']['info'])->toBeArray();

    //VERIFICA O TOTAL DE REGISTROS
    expect($responseCollection['pagination']['info']['total'])->toBe(10);

    //VERIFICA A QUANTIDADE DE REGISTROS POR PÁGINA
    expect($responseCollection['pagination']['info']['perPage'])->toBe(15);

    //VERIFICA A PÁGINA ATUAL
    expect($responseCollection['pagination']['info']['currentPage'])->toBe(1);
  });
});