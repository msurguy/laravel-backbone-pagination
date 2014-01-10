<?php

class ApiProductsController extends \BaseController {

	public function getIndex()
	{
		$perPage = e(Input::get('per_page','6'));
		$page = e(Input::get('page','1'));
		$sort = e(Input::get('sort','popular'));
		$offset = $page*$perPage-$perPage;
		$count = 0;

		switch ($sort) {
			case 'date':
				$sortedProducts = Product::newest();
				break;
			case 'name':
				$sortedProducts = Product::byname();
				break;
			default:
				$sortedProducts = Product::popular();
				break;
		}

		$count = $sortedProducts->count();

		$products = $sortedProducts->take($perPage)->offset($offset)->get(array('slug','rating_cache','name','short_description','icon','banner','pricing'));

		return Response::json(array(
			'data'=>$products->toArray(),
			'total' => $count
		));
	}
}