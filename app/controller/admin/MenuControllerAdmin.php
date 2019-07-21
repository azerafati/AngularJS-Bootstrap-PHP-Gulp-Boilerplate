<?php


class MenuControllerAdmin {

    /**
     * @param Category $cat
     */
    static function page() {
		$controller = HtmlControllerAdmin::create();

        $controller->viewScope( [
					"title" => 'دسته بندی ها',
					"activeSection" => 'category',
					"script" => [
							"angular-ui-tree.min.js",
							"menu.js?v=1.2.1"
					],
					"css" => [
							"angular-tree.css?v=1.0.0"
					]
            ] )->showView( "admin/CategoryPage" );
		}


    static function load() {

            //creating tree from DB
            $tree = MenuRepository::select('parent is null order by sort ASC')?:[];

            function loadNodes(&$node) {
                $node->nodes = MenuRepository::select('parent = :p order by sort ASC', [':p' => $node->id])?:[];
                foreach($node->nodes as $n){
                    $n->hidden = filter_var($n->hidden, FILTER_VALIDATE_BOOLEAN);
                    loadNodes($n);
                }
            }


            foreach ($tree as $node) {
                $node->hidden = filter_var($node->hidden, FILTER_VALIDATE_BOOLEAN);
                $node->nodes = [];
                loadNodes($node);
            }

            echo json_encode($tree);


    }

    static function remove($_req) {
        MenuRepository::delete($_req['id']);
    }


    static function save($_req) {
        $categories = $_req['cats'];

        $newCats = [];

        function getChildren($branch) {
            $sort = 0;
            foreach ((isset($branch['nodes'])?$branch['nodes']:[]) as &$ch) {
                $ch['parent'] = $branch['id'];
                $sort++;
                $ch['sort'] = $sort;
            }
            $children = (isset($branch['nodes'])?$branch['nodes']:[]);
            foreach ($branch['nodes'] as $child) {
                $children = array_merge($children,getChildren($child));
            }
            return $children;
        }
        $sort = 0;
        foreach ($categories as $cat){
            $cat['parent'] = null;
            $sort++;
            $cat['sort'] = $sort;
            $newCats[] = $cat;
            $newCats = array_merge($newCats,getChildren($cat));
        }

        function decentLink($strin){
            return preg_replace('!\s+!', '-', trim($strin));

        }

        foreach ($newCats as &$cat){
            $cat['nodes'] = null;
            $category = new Category();
            $category->id = $cat['id'];
            $category->title = preg_replace('!\s+!', ' ', trim($cat['title']));
            $category->parent = $cat['parent'];
            $category->sort = $cat['sort'];
            $category->hidden = $cat['hidden'];
            $category->url = isset($cat['url'])?decentLink($cat['url']):decentLink($category->title);
            MenuRepository::save($category);
        }


        self::load();
    }

}
