<?php


abstract class Repository {
	protected static $connection;
	static $tableName = "Table_Name";
	static $defaultTimeZone = "+03:30";


	public static function setTimeZone() {
		self::executeQuery(self::getTimeZoneQuery());
	}

	public static function getTimeZoneQuery() {
		return ('SET time_zone = "' . self::$defaultTimeZone . '";');
	}

	/**
	 * Main query function abstracted
	 *
	 * @author Alirzea Zerafati
	 *
	 * @param string $query
	 * @param string $prepareArray
	 * @param class $model
	 * @return mixed <boolean, multitype:>
	 */
	public static function query($query, $prepareArray = false, $model = false, $return=true,$fetchSingle=false) {
		$db = self::getConnection();

		$stmt = $db->prepare( $query );

		if ($model) {
			$stmt->setFetchMode( PDO::FETCH_CLASS, $model );
		} else {
			$stmt->setFetchMode( PDO::FETCH_ASSOC );
		}
		if ($prepareArray) {
			$stmt->execute( $prepareArray );
		} else {
			$stmt->execute();
		}
		if ($return) {
			if ($fetchSingle) {
				return $stmt->fetch();
			} else {
				return $stmt->fetchAll();
			}
		}
	}

	public static function singleResultQuery($query, $prepareArray=false, $model=false) {
		return self::query($query,$prepareArray,$model,true,true);
	}

	/**
	 * Main query function abstracted
	 *
	 * @author Alirzea Zerafati
	 *
	 * @param String $query
	 * @param Array $prepareArray
	 * @param Model $model
	 * @return Ambigous <boolean, multitype:>
	 */
	public static function executeQuery($query, $prepareArray = false) {
		$db = self::getConnection();

		$stmt = $db->prepare( $query );
		if ($prepareArray) {
			$stmt->execute( $prepareArray );
		} else {
			$stmt->execute();
		}
	}

	/**
	 *
	 * @param string $whereClause
	 * @param string $prepareArray
	 * @return mixed
	 */
	static function selectOne($whereClause, $prepareArray = false, $table = false) {
		$db = self::getConnection();
		$table = $table?:static::getTableName();
		$query =  "SELECT * FROM  $table WHERE  $whereClause limit 1" ;
		$stmt = $db->prepare($query);
		$model = static::getModelName();

		$stmt->setFetchMode( \PDO::FETCH_CLASS, $model );
		if ($prepareArray) {
			$stmt->execute( $prepareArray );
		} else {
			$stmt->execute();
		}
		return  $stmt->fetch();
	}



	/**
	 *
	 * @param String $whereClause
	 * @param String $prepareArray
	 * @return static::getModelName ();
	 */
	static function select($whereClause, $prepareArray = false,$table = false) {
		$db = self::getConnection();
		$query =  'SELECT * from ' . ($table?:static::getTableName()) . ' WHERE ' . $whereClause ;
		$stmt = $db->prepare($query);
		$model = static::getModelName();

		$stmt->setFetchMode( \PDO::FETCH_CLASS, $model );
		if ($prepareArray) {
			$stmt->execute( $prepareArray );
		} else {
			$stmt->execute();
		}
		//return $stmt->rowCount() > 0 ? $stmt->fetchAll() : [];
		return $stmt->fetchAll();
	}



	static function get($params) {

		$params = array_merge([
			'where'=>'',
			'prepare'=>false,
			'table'=>false,
			'select'=>'*',
			'join'=>'',
			'model'=>false
		],$params);

		$db = self::getConnection();
		$query =  'SELECT '.$params['select'].' FROM '. ($params['table']?:static::getTableName()) .' '.  $params['join'].' WHERE ' . $params['where'] ;
		$stmt = $db->prepare($query);

		if ($params['model']) {
			$stmt->setFetchMode( PDO::FETCH_CLASS, $params['model'] );
		} else {
			$stmt->setFetchMode( PDO::FETCH_ASSOC );
		}
		if ($params['prepare']) {
			$stmt->execute( $params['prepare']);
		} else {
			$stmt->execute();
		}
		return  $stmt->fetchAll();
	}


	/**
	 * @param int $id
	 * @param String $table
	 * @return Model
	 */
	static function loadById($id, $table=false) {
		return static::selectOne( "id = :id", array (
			':id' => $id
		) ,$table);
	}

	static function delete($id, $table = false) {
		if (! $table)
			$table = static::getTableName();

		$query = "DELETE FROM $table WHERE id=:id";
		self::executeQuery( $query, [
			":id" => $id
		] );
	}

	static function loadAll($table = false, $modelClass = false,$sortOrLimit="") {
		if (! $table)
			$table = static::getTableName();

		if (! $modelClass)
			$modelClass = self::getModelName();

		return static::query( "SELECT * FROM " . $table." ".$sortOrLimit, [ ], $modelClass );
	}

	static function loadAllFiltered($page, $select = "*",$joins='',$groupby='',$table=null) {

		$filter = static::createFilter();
		$filterQuery = $filter->filterQuery();
		if (! $table)
			$table = static::getTableName();

		$tableAlias = trim($table,'_v');

		$query ="
				SELECT $select
				FROM $table $tableAlias $joins WHERE $filterQuery
             $groupby ORDER BY ".static::createSort()." ".PageService::query($page);

		return static::query( $query, $filter->filterPrepareArray, static::getModelName() );

	}

	public static function loadAllFilteredFromView($page) {
		$table = static::getTableName() . '_v';

		return self::loadAllFiltered($page, '*', '', '', $table);
	}


	static function countAllFiltered($joins='',$groupby='', $table=null) {

		$filter = static::createFilter();
		$filterQuery = $filter->filterQuery();
		if (! $table)
			$table = static::getTableName();

		$tableAlias = trim($table,'_v');
		$query = "
			  SELECT count(DISTINCT $tableAlias.id) total
			    FROM $table $tableAlias $joins  
			    WHERE $filterQuery 
			    ";

		$count = static::singleResultQuery($query,$filter->filterPrepareArray);

		return $count['total'];
	}

	static function countAllFilteredFromView() {
		$table = static::getTableName() . '_v';

		return self::countAllFiltered('', '', $table);
	}


	/**
	 *
	 */


	/**
	 * saving entities private variables to DB
	 *
	 * @param Array $model
	 */
	static function insert($model, $rawSql = false, $return = true) {
		return self::insertInto(self::getTableName(),$model,$rawSql,$return);
	}

	static function insertInto($table,$model, $rawSql = false, $return = true) {
		$model = (array) $model;
		if (!is_array($model))
			throw new Exception('provided model is not an array to be inserted into DB');
		//unseting defaults //// conventional
		unset($model['updated_at'],$model['created_at']);


		$insert = "";

		foreach ( array_keys( $model ) as $key ) {
			$insert .= ":" . $key . ",";
		}
		$insert = rtrim( $insert, "," );
		$duplicate = '';
		//in duplicate statement we are not inserting id column again
		foreach ( array_keys( $model ) as $key ) {
			if($key=='id')
				continue;
			$duplicate .= $key."=:" . $key . ",";
		}
		$duplicate = rtrim( $duplicate, "," );

		$allKeys = implode( ",", array_keys( $model ) ) . ($rawSql ? "," . implode( ",", array_keys( $rawSql) ) : "");
		$allValues = $insert. ($rawSql ? "," . implode( ",", array_values( $rawSql ) ) : "");

		$insert = "INSERT INTO $table  ($allKeys) VALUES ( $allValues )
              ON DUPLICATE KEY UPDATE $duplicate
            ";

		$binding = array ();
		foreach ( $model as $key => $val ) {
			//filtering boolean values to 0,1 instead of true,false
			if(is_bool($val)){
				$val = $val?1:0;
			}
			$binding[":" . $key] = $val;

		}


		// Insert the values into the database
		$retry = 5;
		while ($retry) {
			$retry--;
			$db = self::getConnection();
			$stmt = $db->prepare( $insert );

			try {
				$stmt->execute( $binding );
				$retry = 0;
			} catch ( Exception $e ) {
				$msg = $e->getMessage();
				if (strstr( $msg, 'MySQL server has gone away' )) {
					self::$connection = null;
					if(!$retry)
						throw $e;
				} else {
					throw $e;
				}
			}
		}
		if ($return){
			$lastId =  $db->lastInsertId();
			if($lastId==0){
				//meaning that the exact same row was already in DB and so no row was affected therefore we get the id from our object
				$lastId = $model['id'];
			}
			return static::loadById( $lastId,$table );

		}
	}

	static function getTableName() {
		return static::$tableName;
	}

	static function update($id,$column,$newValue,$tableName=null) {
		if(is_bool($newValue)){
			$newValue = $newValue?1:0;
		}
		$tableName = $tableName?:self::getTableName();
		self::query("update $tableName set $column = :newvalue where id= :id",[
			':id'=>$id,
			':newvalue'=>$newValue
		],false,false);
	}
	static function updateDate($id,$column,$newValue) {
		self::query(self::getTimeZoneQuery().' update '.self::getTableName().' set '.$column.' = :newvalue where id= :id',[
			':id'=>$id,
			':newvalue'=>$newValue
		],false,false);
	}

	static function getConnection() {
		if (empty( self::$connection )) {

			if (! $settings = parse_ini_file( constant( 'AppRoot' ) . 'config.ini', true ))
				throw new exception( 'Unable to open config.ini.' );

			self::$connection = new PDO( $settings['database']['host'], $settings['database']['username'], $settings['database']['password'] );
			self::$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			self::$connection->exec(self::getTimeZoneQuery());
		}
		return self::$connection;
	}

	protected static function getModelName() {
		$model = str_replace( "Repository", "", get_called_class() );
		return empty($model)?stdClass::class:$model;
	}

	/**
	 * helper method to filter query
	 *
	 * @return unknown
	 */
	protected static function fQuery($filterProperty, $query, $array) {
		if (isset( $_GET[$filterProperty] )) {
			$array[$filterProperty] = $query;
		}
		return $array;
	}


	protected static function createSort() {
		$sort="id desc";

		return $sort;
	}
}
