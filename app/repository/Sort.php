<?php


/**
 * @author Alireza Zerafati (bludream@gmail.com)
 *
 */
class Sort {
    private $sortArray = [];
    public $defaultSortKey = 1;

	/**
	 * @param $sortArray
	 */
    public function __construct($sortArray) {
    	$this->sortArray = $sortArray;

    }


    public function sortQuery() {
		$_req = $_REQUEST;
		$sort_ids = (isset($_req['sort']) && $_req['sort']!='null') ? $_req['sort'] : $this->defaultSortKey;
		$sort_ids = explode(',', $sort_ids);
		$sort = '';
		foreach ($sort_ids as $sort_id) {
			if(in_array(ltrim($sort_id,'-'),array_keys($this->sortArray))){
				$sort .= $this->sortArray[ltrim($sort_id,'-')];
			}
			$sort .= ' ' . (substr( $sort_id, 0, 1 ) === "-" ? 'ASC ,' : 'DESC ,');
		}
		$sort .= 'id DESC';
		return $sort;
    }


}



