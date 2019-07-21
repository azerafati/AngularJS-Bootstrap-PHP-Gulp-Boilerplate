<?php


class RestController extends Controller {

	/**
	 *
	 * @return RestController
	 */
	static function create() {
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
		header("Pragma: no-cache"); // HTTP 1.0.
		header("Expires: 0");
		Util::header("json");
		return parent::create();
	}

	function run($function) {
		if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') && empty($_POST)) {
			$_req = json_decode(file_get_contents('php://input'), true);
			$_POST = $_REQUEST = $_req;

		}
		parent::run($function);
	}

	function cache($seconds) {
		header_remove('Cache-Control');
		header_remove('Expires');
		header("Cache-Control: max-age=$seconds", true);
		header("Expires: " . gmdate('D, d M Y H:i:s T', time() + $seconds), true);
		header_remove('Pragma');
		//header( "Last-Modified: " . gmdate('D, d M Y H:i:s T',time()-$seconds) );
		return $this;
	}


}