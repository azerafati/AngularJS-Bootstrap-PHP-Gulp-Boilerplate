<?php


class ProductController {

    /**
     * @param Product $product
     */
    static function html($product) {
        $controller = HtmlController::create();
        //$product->cats = CategoryRepository::loadByProd($product->id) ?: [];
        $controller->viewScope(["title" => $product->name,
            'seodesc' => $product->seodesc,
            'product' => $product
        ])->showView("ProductPage");
    }

    /**
     * @param $_req
     * @param $ctrl RestController
     */
    static function page($_req, $ctrl, $user_id) {

        $total = ProductRepository::countAllFiltered();
//		$_req['psize'] = 35;
        $page = PageService::createPage($total, 35, $_req);
        $products = ProductRepository::loadAllFiltered($page);
        $jsonProducts = [];
        $user = UserService::currentUser();
        foreach ($products as $product) {
            $p = [
                'name' => $product->name,
                'code' => $product->code,
                'price' => floatval($product->price),
                'old_price' => $product->old_price > $product->price ? floatval($product->old_price) : null,
                'url' => $product->url,
                'imgs' => intval($product->imgs),
                'rnd' => $product->rnd,
                'rndurl' => $product->rndurl,
                'in_stock' => $product->stock > 0,

            ];
            if ($user->user_group_id == 5) {
                $p['price'] = floatval($product->wholesale_price);
                $p['old_price'] = floatval($product->price);
            }
            $jsonProducts[] = $p;
        }

//		$ctrl->cache(3000);
        PageService::jsonPage($page, $jsonProducts);
        //LoggerAZ::info('HEADERS PAGE+++ '. json_encode(headers_list()));
    }

    /**
     * @param $_req array
     * @param $ctrl Controller
     */
    static function get($_req, $ctrl) {
        //sleep(3);
        if (!isset($_req['rid']))
            $ctrl->badRequest('ID_INVALID');
        /* @var $product Product */
        $product = ProductRepository::loadByRId($_req['rid']);
        if (!$product)
            $ctrl->badRequest('NOT_FOUND');

        /*		if ($product->hidden)
                    $ctrl->badRequest('HIDDEN');*/

        ProductRepository::update($product->id, 'view_count', $product->view_count + 1);
        $mainCat = CategoryRepository::mainCategory($product->id);
        $breadsCategories = [];
        if ($mainCat)
            $breadsCategories = CategoryRepository::loadAncestry($mainCat->id);
        $breads = [];
        foreach ($breadsCategories as $bread) {
            $breads[] = [
                'id' => $bread->id,
                'url' => $bread->url,
                'title' => $bread->title,
            ];
        }
        $p = [
            'name' => $product->name,
            'code' => $product->code,
            'price' => floatval($product->price),
            'old_price' => $product->old_price > $product->price ? floatval($product->old_price) : null,
            'url' => $product->url,
            'active' => $product->active,
            'imgs' => $product->imgs,
            'rnd' => $product->rnd,
            'rndurl' => $product->rndurl,
            'info' => $product->info,
            'tags' => TagRepository::loadByProd($product->id),
            'breadcrumb' => $breads,
            'in_stock' => $product->stock > 0,
            'comment_count' => 0,

            'height' => $product->height,
            'width' => $product->width,
            'opening_diameter' => $product->opening_diameter,
            'body_cover' => $product->body_cover,
            'body_type' => $product->body_type,
            'box_qty' => $product->box_qty,
            'box_color' => $product->box_color,
            'usecase' => $product->usecase,
            'suitable_for' => $product->suitable_for,
            'care_tip' => $product->care_tip,
            'produced_in' => $product->produced_in,
            'production_status' => $product->production_status,
            'is_wholesale' => $product->is_wholesale
        ];
        $user = UserService::currentUser();
        if ($user->user_group_id == 5) {
            $p['price'] = floatval($product->wholesale_price);
            $p['old_price'] = floatval($product->price);
        }
        echo json_encode($p);
    }


}
