<?php

namespace App\Http\Controllers\Content;

use App\Exceptions\Api\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\Content\PostResource;
use App\Models\Content\Post;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Classe controller responsável pelas controladoras das ações das rotas do modelo Post
 * 
 * @author David Guimarães
 */
class PostController extends Controller {
    
  /**
   * Método responsável por buscar um registro pelo ID
   * @param  Post $post Modelo Post
   * @return PostResource
   */
  public function searchModel(Post $post): BaseResource {
    return new PostResource($post);  
  }

  /**
   * Método responsável por buscar uma lista de registros
   * @return ResourceCollection
   */
  public function searchList(): ResourceCollection {
    $listPosts = Post::paginate();
    if($listPosts->isEmpty()) throw new ApiException(404, 'Nenhum post encontrado');

    return PostResource::collection($listPosts);
  }
}
