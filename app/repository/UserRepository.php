<?php


	class UserRepository extends Repository {
		static $tableName = "user";
		static $userFullNameQuery = "concat(IF(user.fname IS NULL,'',concat(user.fname,' ')),COALESCE(user.lname,'')) ";

		/**
		 * @param int $id
		 * @param bool $table
		 * @return User
		 */
		static function loadById($id, $table = false) {
			return parent::loadById($id);
		}

		public static function balanceQuery() {
			$final_priceQuery = OrderRepository::$final_priceQuery;

			return "SELECT 0";
		}

		protected static function createFilter() {
			return new Filter([
					"search" => "concat(user.fname,' ',user.lname) like concat('%',:search,'%') OR user.email like concat('%',:search,'%') OR user.tel like concat('%',:search,'%')",
					"debt" => "user.balance<-5000"
				]
			);
		}

		static function countAllFiltered($joins = '', $groupby = '', $table = NULL) {
			$filter = self::createFilter();
			$filterQuery = $filter->filterQuery();
			$balanceQuery = self::balanceQuery();

			$query = "SELECT count(DISTINCT user.id) total from (
                    SELECT fname,lname,email,user.id,pin,user_group.name group_name,tel,user.created,user.last_login,last_order.created_at last_order, ($balanceQuery) balance
                    FROM user
                    LEFT JOIN user_group on user_group.id = user.user_group_id
                    LEFT JOIN orders o ON o.user_id = user.id
                        left join (select o.id, o.created_at,o.user_id user_id from orders o join (SELECT max(o1.id) id from orders o1 group by o1.user_id) max_id on max_id.id = o.id) last_order on last_order.user_id = user.id
                 WHERE user.tel is not NULL )user  Where $filterQuery
                  ";
			$count = static::query($query, $filter->filterPrepareArray, false, true, true);

			return $count['total'];
		}


		protected static function createSort() {
			$_req = $_REQUEST;
			$sort_ids = isset($_req['sort']) ? $_req['sort'] : 3;
			$sort_ids = explode(',', $sort_ids);
			$sort = '';
			foreach ($sort_ids as $sort_id) {
				switch (abs($sort_id)) {
					case 1:
						$sort .= 'user.created';
						break;
					case 2:
						$sort .= 'user.fname';
						break;
					case 3:
						$sort .= 'user.last_login';
						break;
					case 4:
						$sort .= 'user.last_order';
						break;
					case 5:
						$sort .= 'balance';
						break;
					case 6:
						$sort .= 'balance';
						break;
					default:
						$sort .= 'buydate';
				}
				$sort .= ' ' . (($sort_id < 0) ? 'ASC ,' : 'DESC ,');
			}
			$sort .= 'user.id DESC';
			return $sort;
		}

		/**
		 *
		 * @param String $email
		 * @return User
		 */
		public static function loadByEmail($email) {
			$row = self::selectOne("email = :email", array(
				':email' => $email
			));
			return $row;
		}

		/**
		 * @param int $tel
		 * @return User
		 */
		public static function loadByTel($tel) {
			return self::selectOne("tel = :tel", [
				':tel' => $tel
			]);
		}

		public static function loadByIdWithDetails($id) {
			return self::singleResultQuery("SELECT user.*, ug.name group_name
FROM user
       left join user_group ug on user.user_group_id = ug.id
WHERE user.id = :id ", array(
				':id' => $id
			));
		}

		/**
		 * @param User $user
		 * @return Model|User
		 */
		public static function save($user) {

			OrderRepository::setTimeZone();
			return parent::insert($user);

		}

		public static function getSumPayments($user_id) {
			$query = "
SELECT 
    COALESCE(SUM(p.amount), 0) - COALESCE((SELECT 
                    SUM(upayment.amount)
                FROM
                    payment upayment
                WHERE
                    upayment.user_id = :id
                        AND upayment.income = 2 AND upayment.ok IS TRUE),
            0) sum
FROM
    payment p
WHERE
    p.user_id = :id AND p.ok IS TRUE
        AND p.income = 1
				";

			$result = self::query($query, [
				":id" => $user_id
			]);
			return $result ? $result[0]['sum'] : false;
		}


		public static function getSumOrders($user_id) {
			$final_priceQuery = OrderRepository::$final_priceQuery;
			$result = self::query("SELECT SUM(total.final_price) sum
FROM (SELECT $final_priceQuery final_price
      FROM user
        JOIN orders o ON o.user_id = user.id AND o.is_open IS FALSE AND o.status != 1
        LEFT JOIN
        (SELECT it.*
         FROM
           order_item it
           INNER JOIN order_item_status ON it.status = order_item_status.id
                                           AND order_item_status.cancel IS FALSE) order_item ON order_item.order_id = o.id
        LEFT JOIN (
                    SELECT
                      sum(c.discount) discount,
                      c.order_id
                    FROM coupon_order c
                    GROUP BY c.order_id
                  ) coupon ON coupon.order_id = o.id
      WHERE user.id = :user_id
      GROUP BY o.id) AS total
				", [
				':user_id' => $user_id
			]);

			return $result ? $result[0]['sum'] : false;
		}


		public static function countPackageQue() {
			$filter = static::createFilter();


			$result = self::query('
                  SELECT count(DISTINCT user.id) count
                  FROM user
                    INNER JOIN orders o ON o.user = user.id AND o.open IS FALSE AND o.status != 1
                    INNER JOIN order_item item ON item.order_id = o.id AND item.status IN ( 8,9)
                    ' . (empty($filter->filterQuery()) ? '' : 'WHERE ') . ltrim($filter->filterQuery(), ' AND'), $filter->filterPrepareArray);

			return $result[0]['count'];
		}

		public static function loadAllPackageQue($page) {

			$filter = static::createFilter();

			$result = self::query('
                  SELECT user.*,
                        sum(item.qty)  items,
                        sum(item.qty * item.weight)items_weight,
                        o.created fdate
                 /* (SELECT price
						             FROM pkg_price
						            WHERE (coalesce(SUM(item.qty * item.weight),0))  BETWEEN min AND max
						            LIMIT 1) +

                                    coalesce((SELECT price
				             FROM post_plan_price
				            WHERE     post_plan_id = s.post_plan_id
				                  AND (coalesce(SUM(item.qty * item.weight),0)) BETWEEN min AND max
				            LIMIT 1),0) shipment_price*/

                  FROM user

                    INNER JOIN orders o ON o.user = user.id AND o.open IS FALSE AND o.status != 1
                    INNER JOIN order_item item ON item.order_id = o.id AND item.status IN ( 8,9)
                     ' . (empty($filter->filterQuery()) ? '' : 'WHERE ') . ltrim($filter->filterQuery(), ' AND') . ' GROUP BY USER.id ORDER BY o.created ASC ' . PageService::query($page), $filter->filterPrepareArray);

			return $result;
		}


		public static function findByCookie($cookie) {
			$result = self::query('SELECT user.* FROM user_session JOIN user ON user_session.user_id = user.id WHERE user_session.cookie=:cookie LIMIT 1', [':cookie' => $cookie], User::class);

			return empty($result) ? false : $result[0];
		}

		/**
		 * @param $user User
		 * @param $cookie string
		 */
		public static function insertCookie($user, $cookie) {
			self::insertInto('user_session', ['user_id' => $user->id, 'cookie' => $cookie], false, false);
		}

		/**
		 * @param $user User
		 * @param $cookie string
		 */
		public static function removeCookie($user, $cookie) {
			self::executeQuery('DELETE FROM user_session WHERE user_id=:id AND cookie=:cookie', [':id' => $user->id,
				':cookie' => $cookie]);
		}

		/**
		 * @param $user User
		 * @param $guestUser User
		 */
		public static function mergeGuestWithUser($user, $guestUser) {
			//updating order items to the basket
			$basket = OrderRepository::loadCart($user->id);
			self::executeQuery('UPDATE order_item item JOIN orders o ON o.user_id =:user_id AND o.id = item.order_id
                                  SET item.order_id = :basket', [':user_id' => $guestUser->id,
				':basket' => $basket->id]);
			self::executeQuery('UPDATE address SET address.user = :user_id WHERE address.user =:guest_id', [':guest_id' => $guestUser->id, ':user_id' => $user->id]);
			self::executeQuery('UPDATE payment SET user_id = :user_id,order_id=:basket WHERE user_id =:guest_id',
				[':guest_id' => $guestUser->id, ':user_id' => $user->id, ':basket' => $basket->id]);

			OrderRepository::executeQuery('DELETE FROM orders WHERE user_id=:guest_id', [':guest_id' => $guestUser->id]);
			UserRepository::delete($guestUser->id);
		}

		public static function loadAllFilteredForAdminPanel($page) {
			$filter = self::createFilter();
			$filterQuery = $filter->filterQuery();
			$sort = self::createSort();
			$balanceQuery = self::balanceQuery();
			$fullNameQuery = UserRepository::$userFullNameQuery;

			$pageQuery = PageService::query($page);
			$query = "SELECT user.*
from (SELECT fname,
             lname,
             $fullNameQuery          name,
             company,
             known_as,
             email,
             user.id,
             user.rnd_img,
             pin,
             user_group.name            group_name,
             user_group.id              group_id,
             tel,
             user.created               created,
             user.last_login,
             MAX(last_order.created_at) last_order,
             ($balanceQuery)         balance
      FROM user
             LEFT JOIN user_group on user_group.id = user.user_group_id
             LEFT JOIN orders o ON o.user_id = user.id
             LEFT JOIN (select o.id, o.created_at, o.user_id user_id
                        from orders o
                               join (SELECT max(o1.id) id from orders o1 group by o1.user_id) max_id
                                 on max_id.id = o.id) last_order on last_order.user_id = user.id
      WHERE user.tel is not NULL
      GROUP by user.id)user
Where $filterQuery
ORDER BY $sort $pageQuery";

			return static::query($query, $filter->filterPrepareArray, User::class);
		}


	}
