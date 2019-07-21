<?php


class RestControllerAdmin extends RestController {

	/**
	 * creating a RestController default authorized to admin
	 * @return RestController
	 */
	static function create() {
		$controller = parent::create()->authorize(['admin']);
		return $controller;
	}


	function authorize($userGroups) {
		if (!UserService::isUserAdmin()) {
			http_response_code(405);
			exit ();
		}
		return $this;
	}


}