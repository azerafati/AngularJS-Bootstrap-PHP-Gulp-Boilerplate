<?php


class ProductControllerAdmin {


    /**
     * @param $_req
     * @param $ctrl RestController
     */
    static function page($_req, $ctrl) {
        $total = ProductRepository::countAllFilteredAdmin();

        $page = PageService::createPage($total, 30, $_req);
        $products = ProductRepository::loadAllFilteredAdmin($page);
        $jsonProducts = [];
        foreach ($products as $product) {
            $cats = CategoryRepository::loadByProd($product->id);
            $jsonCats = [];
            foreach ($cats as $cat) {
                $jsonCats[] = [
                    'id' => $cat->id,
                    'name' => $cat->title,
                ];
            }
            $jsonProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'price' => floatval($product->price),
                'wholesale_price' => $product->wholesale_price,
                'purchase_price' => $product->purchase_price,
                'stock' => $product->stock,
                'hidden' => $product->hidden,
                'url' => $product->url,
                'imgs' => intval($product->imgs),
                'rnd' => $product->rnd,
                'rndurl' => $product->rndurl,
                'categories' => $jsonCats,

            ];
        }
        PageService::jsonPage($page, $jsonProducts);
    }


    /**
     * @param $_req array
     * @param $ctrl Controller
     */
    static function get($_req, $ctrl) {
        //sleep(3);
        if (!isset($_req['id']))
            $ctrl->badRequest('ID_INVALID');
        /* @var $product Product */
        $product = ProductRepository::loadById($_req['id']);
        if (!$product)
            $ctrl->badRequest('NOT_FOUND');

        ProductRepository::update($product->id, 'view_count', $product->view_count + 1);
        $cats = CategoryRepository::loadByProd($product->id);
        $jsonCats = [];
        foreach ($cats as $cat) {
            $jsonCats[] = [
                'id' => $cat->id,
                'name' => $cat->title,
            ];
        }
        $p = [
            'id' => $product->id,
            'name' => $product->name,
            'code' => $product->code,
            'price' => floatval($product->price),
            'old_price' => $product->old_price,
            'url' => $product->url,
            'active' => $product->active,
            'imgs' => $product->imgs,
            'rnd' => $product->rnd,
            'rndurl' => $product->rndurl,
            'info' => $product->info,
            'wholesale_price' => $product->wholesale_price,
            'purchase_price' => $product->purchase_price,
            'stock' => $product->stock,
            'weight' => $product->weight,
            'hidden' => $product->hidden,
            'seodesc' => $product->seodesc,
            //'tags' => TagRepository::loadByProd($product->id),
            'categories' => $jsonCats,

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
            'is_wholesale' => $product->is_wholesale,

        ];

        echo json_encode($p);
    }


    static function remove($_req) {
        ProductRepository::delete($_req['id']);
    }


    static function save($_req, $ctrl) {

        if (isset($_req['id'])) {
            $product = ProductRepository::loadById($_req['id']);
            if (!$product)
                $ctrl->badRequest('ID_INVALID');
        } else {
            //no id then it's a new product
            $product = new Product();
            $rndUrl = Util::generateRandomId(3);
            while (ProductRepository::selectOne('rndurl=:rndurl', ['rndurl' => $rndUrl])) {
                $rndUrl = Util::generateRandomId(3);
            }
            $product->rndurl = $rndUrl;
            $product->active = true;
            $product->stock = 1;
            $product->seodesc = '';
            $product->sort = 0;
            $product->price = 0;
            $product->old_price = 0;
            $product->wholesale_price = 0;
            $product->purchase_price = 0;
            $product->weight = 500;
        }
        $product->name = preg_replace('!\s+!', ' ', trim($_req['name'] ?? $product->name));
        $product->url = Util::decentLink(checkSet($_req, 'url', $product->name));
        if (!strlen($product->url)) {
            $product->url = Util::decentLink($product->name);
            if (!strlen($product->url)) {
                $ctrl->badRequest('URL_INVALID');
            }
        }
        $product->price = $_req['price'] ?? $product->price;
        $product->old_price = $_req['old_price'] ?? $product->old_price;
        $product->wholesale_price = $_req['wholesale_price'] ?? $product->wholesale_price;
        $product->purchase_price = $_req['purchase_price'] ?? $product->purchase_price;
        $product->hidden = $_req['hidden'] ?? $product->hidden;
        $product->active = $_req['active'] ?? $product->active;
        $product->code = $_req['code'] ?? $product->code;
        $product->info = $_req['info'] ?? $product->info;
        $product->stock = $_req['stock'] ?? $product->stock;
        $product->seodesc = $_req['seodesc'] ?? $product->seodesc;
        $product->sort = $_req['sort'] ?? $product->sort;
        $product->weight = $_req['weight'] ?? $product->weight;

        $product->height = $_req['height'] ?? $product->height;
        $product->width = $_req['width'] ?? $product->width;
        $product->opening_diameter = $_req['opening_diameter'] ?? $product->opening_diameter;
        $product->body_cover = $_req['body_cover'] ?? $product->body_cover;
        $product->body_type = $_req['body_type'] ?? $product->body_type;
        $product->box_qty = $_req['box_qty'] ?? $product->box_qty;
        $product->box_color = $_req['box_color'] ?? $product->box_color;
        $product->usecase = $_req['usecase'] ?? $product->usecase;
        $product->suitable_for = $_req['suitable_for'] ?? $product->suitable_for;
        $product->care_tip = $_req['care_tip'] ?? $product->care_tip;
        $product->produced_in = $_req['produced_in'] ?? $product->produced_in;
        $product->production_status = $_req['production_status'] ?? $product->production_status;
        $product->is_wholesale = $_req['is_wholesale'] ?? $product->is_wholesale;
        $product = ProductRepository::save($product);
        //$product = ProductService::renamePictures($product);

        //saving cats
        $cats = checkSet($_req, 'categories', []);

        if (isset($_req['categories']))
            ProductRepository::executeQuery('DELETE FROM product_category WHERE product_id = :id ', [':id' => $product->id]);
        foreach ($cats as $cat) {
            if (empty($cat['id'])) {
                //$cat = (array)CategoryRepository::saveNewByTitle($cat['title']);
            }
            ProductRepository::executeQuery('INSERT INTO product_category (product_id,category_id) VALUES(:pid,:cid) ', [':pid' => $product->id,
                ':cid' => $cat['id']]);
        }

        //checking code
        if (empty($product->code)) {
            ProductRepository::setCode($product->id);
        }

        echo json_encode($product);
    }

    /**
     * @param $_req
     * @param $ctrl RestController
     */
    static function saveImg($_req, $ctrl) {
        if (!$_req['id'] || !count($_FILES))
            $ctrl->badRequest('no id or image');

        $f = $_FILES;
        /* @var $product Product */
        $product = ProductRepository::loadById($_req['id']);
        if (!$product)
            $ctrl->badRequest('ID_INVALID');
        $prodImgPath = AppRoot . '../res/img/prod/';

        $oldProductRnd = $product->rnd;

        $product->rnd = Util::generateRandomId(4);
        while (file_exists($prodImgPath . $product->rnd)) {
            $product->rnd = Util::generateRandomId(4);
        }

        ProductRepository::update($product->id, 'rnd', $product->rnd);
        if ($oldProductRnd && file_exists($prodImgPath . $oldProductRnd)) {
            rename($prodImgPath . $oldProductRnd, $prodImgPath . $product->rnd);
        }

        $prodImg = $prodImgPath . $product->rnd . '/';
        if (!file_exists($prodImg)) {
            mkdir($prodImg);
        }
        $i = 0;
        foreach ($_FILES as $file) {
            if ($i >= 10)
                break;
            $img = $prodImgPath . $product->rnd . '/' . $product->url . '-' . ($i > 0 ? $i : '') . 'z.jpg';
            move_uploaded_file($file['tmp_name'], $img);
            $resize = new Imagick();
            $resize->readImage($img);

            $resize->setImageFormat('jpg');
            $resize->setImageCompression(Imagick::COMPRESSION_JPEG);
            $resize->setImageCompressionQuality(83);
            $profiles = $resize->getImageProfiles("icc", true);
            $resize->stripImage();
            if (!empty($profiles))
                $resize->profileImage("icc", $profiles['icc']);

            $resize->resizeimage(640, 640, Imagick::FILTER_LANCZOS, 1);
            if (isset($_req['watermark']) && filter_var($_req['watermark'], FILTER_VALIDATE_BOOLEAN)) {
                $wt = new Imagick(realpath(AppRoot . 'asset/wt.png'));
                //$wt->setImageOpacity(0.1);
                $wt->resizeimage(640, 640, Imagick::FILTER_LANCZOS, 1);

                $resize->compositeImage($wt, imagick::COMPOSITE_COLORBURN, 0, 0);
                $corner = new Imagick(realpath(AppRoot . 'asset/watermark-corner.png'));

                $resize->compositeImage($corner, imagick::COMPOSITE_DEFAULT, 0, 540);
            }

            $resize->writeimage($img);
            $resize->resizeimage(300, 300, Imagick::FILTER_LANCZOS, 1);
            $thumb = str_replace(($i > 0 ? 'z.jpg' : '-z.jpg'), '.jpg', $img);
            $resize->writeimage($thumb);
            $resize->clear();
            $resize->destroy();

            $i++;
        }
        ProductRepository::update($product->id, 'imgs', $i);
    }


    /**
     * @param $_req array
     * @param $ctrl Controller
     */
    static function edit($_req, $ctrl) {
        //sleep(3);
        if (!isset($_req['ids']))
            $ctrl->badRequest('ID_INVALID');
        $ids = $_req['ids'];
        if (!isset($_req['val']))
            $ctrl->badRequest('ID_INVALID');

        $val = $_req['val'];

        if (!isset($_req['property']))
            $ctrl->badRequest('ID_INVALID');
        $property = $_req['property'];

        $actions = ['categories'];
        if (in_array($property, $actions)) {

            switch ($property) {
                case 'categories':
                    //saving cats
                    $cats = $val;
                    foreach ($ids as $id) {
                        $product = ProductRepository::loadById($id);
                        if ($product) {
                            ProductRepository::executeQuery('DELETE FROM product_category WHERE product_id = :id ', [':id' => $product->id]);
                            foreach ($cats as $cat) {
                                if (!empty($cat['id'])) {
                                    ProductRepository::executeQuery('INSERT INTO product_category (product_id,category_id) VALUES(:pid,:cid) ', [':pid' => $product->id,
                                        ':cid' => $cat['id']]);
                                }
                            }
                        }
                    }
                    break;
            }
        }
    }


}
