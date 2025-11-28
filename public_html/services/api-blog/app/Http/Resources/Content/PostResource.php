<?php

namespace App\Http\Resources\Content;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

/**
 * Classe resource responsável pela formatação dos dados do modelo Post em uma resposta JSON
 * 
 * @author David Guimarães
 */
class PostResource extends BaseResource {

	/**
	 * Método responsável por transformar o recurso em um array
	 *
	 * @param  Request  $request
	 * @return array
	 */
	public function toArray(Request $request) {
		return [
			'id'        => (int)	 $this->id,
			'title'     => (string)$this->title,
			'content'   => (string)$this->content,
			'createdAt' => (string)$this->created_at,
			'updatedAt' => (string)$this->updated_at,
		];
	}
}