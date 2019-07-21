<?php


class CategoryController {

	/**
	 * @param Category $cat
	 */
	static function page($cat) {
		$controller = HtmlController::create();

		$controller->viewScope([
			"title" => $cat->title,
			"category" => $cat,
			"seodesc" => $cat->seodesc
		])->showView("CategoryPage");
	}


	static function loadAll() {
		$categories = CategoryRepository::loadAll(false, false, 'order by sort asc');
		echo json_encode($categories);
	}


	static function get($_req) {

		$category = CategoryRepository::loadById($_req['id']);
		$breadcrumbs = CategoryRepository::loadAncestry($category->id);
		foreach ($breadcrumbs as $bread){
			$jsonBreadcrumb[] = [
				'id'=>$bread->id,
				'url'=>$bread->url,
				'title'=>$bread->title,
			];
		}
		/* @var $category Category*/
		$json = [
			'id'=>$category->id,
			'img'=>$category->img,
			'info'=>$category->info,
			'url'=>$category->url,
			'title'=>$category->title,
			'breadcrumb'=>$jsonBreadcrumb
		];

		echo json_encode($json);
	}


	static function load() {

		//creating tree from DB
		$tree = CategoryRepository::select('parent is null AND hidden is false order by sort ASC');

		function loadNodes(&$node) {
			$node->url = $node->url ?: str_replace(' ', '-', $node->title);
			$node->nodes = CategoryRepository::select('parent = :p AND hidden is false order by sort ASC', [':p' => $node->id]) ?: [];
			foreach ($node->nodes as $n) {

				loadNodes($n);
			}
		}


		foreach ($tree as &$node) {
			loadNodes($node);
		}

		echo json_encode($tree);
	}


	static function catList($_req) {

		//creating tree from DB
		/* @var $cat Category */
		$cat = CategoryRepository::loadById($_req['id']);
		if (!$cat) {
			Util::badReq('no category with that id');
		}
		$tree = [];

		if ($cat->parent == null) {
			$tree = $cat;
		} else if (CategoryRepository::selectOne('parent = :p AND hidden is false', [':p' => $cat->id])) {
			$tree = $cat;
		} else {
			$tree = CategoryRepository::loadById($cat->parent);
		}
		$tree->nodes = CategoryRepository::select('parent = :p AND hidden is false order by sort ASC', [':p' => $tree->id]) ?: [];


		echo json_encode($tree);
	}


}
