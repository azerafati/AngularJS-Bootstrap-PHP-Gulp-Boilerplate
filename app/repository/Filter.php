<?php


/**
 * @author Alireza Zerafati (bludream@gmail.com)
 *
 */
class Filter {
	public $filterPrepareArray = [];
	public $filterQueryArray = [];

	/**
	 *
	 * @param array $filters
	 *            return Filter
	 */
	public function __construct($filters) {
		foreach ($filters as $key => $query) {
			$this->bind($key, $query);
		}
	}

	public function bindArray($prefix, $query, $values = false) {
		if (empty($values)) {
			$values = explode(",", isset($_REQUEST[$prefix]) ? $_REQUEST[$prefix] : '');
		}
		if (!empty($values[0])) {
			$str = [];
			foreach ($values as $index => $value) {
				$str[] = ":" . $prefix . $index;
				$this->filterPrepareArray[":" . $prefix . $index] = $value;
			}
			$str = implode(",", $str);
			$query = str_replace(":" . $prefix, $str, $query);
			$this->filterString .= " And " . $query;
		}
	}

	public function bind($key, $query) {
		if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])) {
			$this->set($key, $query, $_REQUEST[$key]);
		}
	}

	public function set($key, $query, $value) {
		$this->filterPrepareArray[':'.$key] = urldecode($value);
		$this->filterQueryArray[':'.$key] = $query;
	}

	public function filterQuery() {
		$query = '';
		forEach ($this->filterPrepareArray as $key => $value) {
			$query .= ' AND ' . ($this->filterQueryArray[$key]) . ' ';
		}
		$query = ltrim($query, ' AND');

		return empty($query)?' TRUE':$query;
	}
}



