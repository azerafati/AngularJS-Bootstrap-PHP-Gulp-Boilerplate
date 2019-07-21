<?php


class ProductRepository extends Repository {
    static $tableName = "product";

    public static function countAllFiltered($joins = '', $groupby = '', $table = NULL) {
        $filter = self::createFilter();
		$filter->set('hidden','product.hidden =:hidden',0);

		$filterQuery = $filter->filterQuery();

        $query = "SELECT count(DISTINCT product.id) total
FROM product
  LEFT JOIN product_category pc on pc.product_id = product.id
  LEFT JOIN category on category.id = pc.category_id
  LEFT JOIN category pcategory on category.lft BETWEEN pcategory.lft AND pcategory.rgt
WHERE $filterQuery";

        return static::query($query, $filter->filterPrepareArray, false,true,true)['total'];
    }

	/**
	 * @param $page
	 * @param string $select
	 * @param string $joins
	 * @param string $groupby
	 * @param null $table
	 * @return Product[]
	 */
	public static function loadAllFiltered($page, $select = "*", $joins = '', $groupby = '', $table = NULL) {
        $filter = self::createFilter();
		$filter->set('hidden','product.hidden =:hidden',0);

		$filterQuery = $filter->filterQuery();
        $sort = self::createSort();

        $pageQuery = PageService::query($page);
        $query = "SELECT
                      product.*
                    FROM product
                        LEFT JOIN product_category pc on pc.product_id = product.id
                        LEFT JOIN category on category.id = pc.category_id
                        LEFT JOIN category pcategory on category.lft BETWEEN pcategory.lft AND pcategory.rgt
                        LEFT JOIN (SELECT count(item.id) sale_count,item.product_id FROM order_item item group by item.product_id) sale ON sale.product_id=product.id
                    Where $filterQuery GROUP by product.id ORDER BY $sort $pageQuery";

        return static::query($query, $filter->filterPrepareArray, Product::class);
    }
	/**
	 * @param $page
	 * @param string $select
	 * @param string $joins
	 * @param string $groupby
	 * @param null $table
	 * @return Product[]
	 */
	public static function loadAllFilteredAdmin($page, $select = "*", $joins = '', $groupby = '', $table = NULL) {
        $filter = self::createFilter();
        $filterQuery = $filter->filterQuery();
        $sort = self::createSortAdmin();

        $pageQuery = PageService::query($page);
        $query = "SELECT
                      product.*
                    FROM product
                        LEFT JOIN product_category pc on pc.product_id = product.id
                        LEFT JOIN category on category.id = pc.category_id
                        LEFT JOIN category pcategory on category.lft BETWEEN pcategory.lft AND pcategory.rgt
                        LEFT JOIN (SELECT count(item.id) sale_count,item.product_id FROM order_item item group by item.product_id) sale ON sale.product_id=product.id
                    Where $filterQuery GROUP by product.id ORDER BY $sort $pageQuery";

        return static::query($query, $filter->filterPrepareArray, Product::class);
    }

    public static function findByUrl($url) {
        return self::selectOne('url= :url',[':url'=>$url]);
    }

    protected static function createFilter() {
        $filter = new Filter(['search' => "product.name like concat('%',:search,'%') OR product.code like concat('%',:search,'%') ",
                              'cat' => 'pcategory.id=:cat']);
        return $filter;
    }



	protected static function createSort() {


		$sort = new Sort([
			1 => 'id',
			2 => 'product.created_at',
			3 => 'price',
			4 => 'view_count',
			5 => 'MAX(sale.sale_count)',
			6 => 'order_status_id',

		]);

		return $sort->sortQuery();
	}


	protected static function createSortAdmin() {

		$sort = new Sort([
			1 => 'product.id',
			2 => 'product.name',
			3 => 'CAST(product.code AS UNSIGNED)',
			4 => 'product.stock',
			5 => 'product.purchase_price',
			6 => 'product.wholesale_price',
			7 => 'product.price',
			8 => 'count(category.id)',

		]);

		return $sort->sortQuery();
	}




	/**
     * @param $product Product
     * @return Product
     */
    public static function save($product) {
        if ($product->sort == null) {
            $product->sort = 0;
        }
        $product->hidden = $product->hidden ? 1 : 0;
        $product->active = $product->active ? 1 : 0;

        return self::insert((array)$product);
        /* Repository::setTimeZone();

         return parent::executeQuery('INSERT INTO product (id, name,url,hidden,info,rnd) VALUES(:id, :name, :url,:hidden,:info,:rnd) ON DUPLICATE KEY UPDATE
                               name=:name, url=:url,hidden = :hidden,url = :url,info = :info,rnd = :rnd',
               ['id' => $product->id,
                'name' => $product->name,
                'hidden' => $product->hidden?1:0,
                'price' => $product->price,
                'info' => $product->info,
                'rnd' => $product->rnd,
                'url' => $product->url,
                ], ["created" => "NOW()"]);*/
    }

	/**
	 * @param $rid
	 * @return Product
	 */
	public static function loadByRId($rid) {
		return self::selectOne('rndurl= :rid',[':rid'=>$rid]);

	}

	public static function countAllFilteredAdmin() {
		$filter = self::createFilter();
		$filterQuery = $filter->filterQuery();

		$query = "SELECT
                      count(DISTINCT product.id) total
                    FROM product
                        LEFT JOIN product_category pc on pc.product_id = product.id
                        LEFT JOIN category on category.id = pc.category_id
                        LEFT JOIN category pcategory on pcategory.id = pc.category_id AND pcategory.lft BETWEEN category.lft AND category.rgt
                    WHERE $filterQuery";

		return static::query($query, $filter->filterPrepareArray, false, true, true)['total'];


	}

	public static function setCode($id) {
		LoggerAZ::debug('setting code for product= '.$id);
		$headCategory = self::singleResultQuery('SELECT 
            pc.category_id id
        FROM
            product_category pc
                JOIN
            category ON category.id = pc.category_id
                JOIN
            category parent ON category.lft BETWEEN parent.lft AND parent.rgt
        WHERE
            pc.product_id = :product_id
                AND pc.category_id < 1000
        ORDER BY parent.id ASC , category.id DESC LIMIT 1', [':product_id' => $id], stdClass::class);

		if (!$headCategory) return;

		$lastCode = self::singleResultQuery('SELECT MAX(CAST(p.code AS UNSIGNED)) `code`
FROM
  product p
  JOIN
  product_category pc ON pc.product_id = p.id
                         AND pc.category_id = :category_id
WHERE p.code LIKE concat(:category_id,\'0%\')', [':category_id' => $headCategory->id], stdClass::class);


		if (!$lastCode->code) {
			$newCode = $headCategory->id . '01';
		} else {
			$newCode = $headCategory->id . '0';
			$counter = explode('0', $lastCode->code,2);
			if(!isset($counter[1])) return;
			$newCode .= intval($counter[1])+1;
		}

		self::update($id, 'code', $newCode);
		LoggerAZ::debug('a code was set for product= '.$id.' code= '.$newCode);

	}

	public static function loadByCode($code) {
		return self::selectOne('code= :code',[':code'=>$code]);
	}


}
