<?php



class PageService {

	/**
	 * @param array $page
	 * @param array $content
	 * @return string 
	 */
	static function jsonPage($page,$content) {
		
			$json = [ 
				"content" => $content,
				"page" => [ 
						"number" => $page['number'],
						"size" => $page['limit'],
						"total" => intval($page['total'])
				] 
		];
		
		echo json_encode($json);
	}

	
	static function createPage($total,$pageSize=20,$_req=null){
        if($_req==null)
            $_req = $_REQUEST;
		$limit = isset( $_req['psize'] ) ? intval( $_req['psize'] ) : $pageSize;
		$pageNumber = intval( isset( $_req['p'] ) ? $_req['p'] : 1 );
		
		if($pageNumber<=0)
			$pageNumber = 1;
		
		$ceil = ceil($total/$limit)?:1;
		if($pageNumber>$ceil)
			$pageNumber = $ceil;
		
		$offset = ($pageNumber - 1) * $limit;
		$page = ["limit"=> $limit,"offset"=>$offset,"total"=>$total,"number"=>$pageNumber];
		return $page;
	}
	
	static function query($page){
		return " limit ".$page['limit']." offset ".$page['offset'];
	}
	
	
	
}