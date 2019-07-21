<?php

	class RouterService {

		static function userRouter() {
			$router = new AltoRouter();
			$router->setBasePath('/');
			$routes = ['me', 'سبد-خرید'];
			foreach ($routes as $route) {
				$router->map('GET', ($route), function () {
					HomeController::index();
				});
			}
			$router->map('GET', '', function () {
				HomeController::index();
			})->map('GET', 'login', function () {
				HomeController::loginPage();
			})->map('POST', 'api/login', function () {
				HomeController::login();
			})->map('GET|POST', 'logout', function () {
				HomeController::logout();
			})->map('POST', 'api/signup', function () {
				HomeController::signup();
			});


			$router->map('GET|POST', 'api/[:controller]/[:action]', function ($controller, $action) {
				$controller = ucfirst($controller);
				$controller = $controller . 'Controller';

				$filename = AppRoot . "controller/" . $controller . ".php";
				if (file_exists($filename)) {
					require_once($filename);
					if (class_exists($controller, false) && method_exists($controller, $action) && is_callable([$controller,
							$action])
					) {
						RestController::create()->run("$controller::$action");
					} else {
						throw new Exception("There is no Method with the name $action in $controller");
					}

				} else {
					throw new Exception("There is no Controller with the name $controller");

				}

			});

			$match = $router->match();
			// call closure or throw error-pages status
			if ($match && is_callable($match['target'])) {
				call_user_func_array($match['target'], $match['params']);
			} else {
				// no route was matched
				HtmlController::notFound();
				//not found is handled with angular

			}


		}


		public static function adminRouter() {
			$router = new AltoRouter();
			$router->setBasePath('/admin/');
			$routes = ['dashboard',
				'log',
				'users',
				'user/[:id]',
			];
			foreach ($routes as $route) {
				$router->map('GET', ($route), function () {
					HtmlControllerAdmin::create()->setBase(false)->showView('admin/admin-index');
				});
			}
			$router->map('GET|POST', 'api/[:controller]/[:action]', function ($controller, $action) {
				$controller = ucfirst($controller);
				$controller = $controller . 'ControllerAdmin';
				$filename = AppRoot . "controller/admin/" . $controller . ".php";
				if (file_exists($filename)) {
					require_once($filename);
					if (class_exists($controller, false) && method_exists($controller, $action) && is_callable([$controller, $action])
					) {
						RestControllerAdmin::create()->run("$controller::$action");
					} else {
						Util::badReq('method' . $controller . '::' . $action);
					}
				} else {
					Util::badReq('method' . $controller . '::' . $action);
				}
			});

			$match = $router->match();
			// call closure or throw error-pages status
			if ($match && is_callable($match['target'])) {
				call_user_func_array($match['target'], $match['params']);
			} else {
				// no route was matched
				HtmlControllerAdmin::notFound();
			}
		}

	}