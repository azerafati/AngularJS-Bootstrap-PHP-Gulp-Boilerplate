<?php

	require('app/AutoLoader.php');
	date_default_timezone_set('Asia/Tehran');

	$router = new AltoRouter();
	$router->map('GET|POST', '/admin/[**:path]', function ($path) {
		RouterService::adminRouter();
	})->map('GET', '/admin/?', function () {
		Util::redirect('/admin/dashboard');
	});


	$match = $router->match();
	if ($match) {
		call_user_func_array($match['target'], $match['params']);
	} else {
		try {
			UserService::createUserFromSession();
			RouterService::userRouter();
		} catch (Exception $e) {
			LoggerAZ::fatal($e->getMessage(), 'index');
			HtmlController::notFound();
		}
	}



