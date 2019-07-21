<?php


class HomeController {

	static function index() {
		$controller = HtmlController::create();
		//if (UserService::isUserSignedIn()) {
		/*if (isset($_REQUEST['r'])) {
			$controller->redirect(str_replace(['//', 'http'], '', $_REQUEST['r']));
		}*/
		$controller->viewScope(["title" => "boilerplate"])->showView("mainPage");
	}


	static function loginPage() {
		$controller = HtmlController::create();
		if (UserService::isUserSignedIn()) {
			if (isset($_REQUEST['r'])) {
				$controller->redirect(str_replace(['//', 'https'], '', $_REQUEST['r']));
			} else {
				$controller->redirect('/');
			}
			exit();
		} else {
			HomeController::index();
		}
	}

	static function logout() {
			if (UserService::isUserSignedIn()) {
				UserService::signOut();
			}
			header('location: /');
	}

	static function changePassword() {
		if (UserService::isUserSignedIn()) {
			Util::badReq();
		}
		RestController::create()->run(function ($_req) {
			//TODO more seccurity mmaybe a sesssion key too
			if (!(isset($_req['pin']) && isset($_req['pass']) && isset($_req['tel']))) {
				Util::badReq();
			}
			$tel = $_req['tel'];
			if (!preg_match('/^09[0-9]{9}$/', $tel)) {
				Util::badReq(3);
			}
			$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
			if (strlen($pass) < 5) {
				Util::badReq(2);
			}
			$user = UserRepository::loadByTel($tel);
			if ($user && $user->pin === ($_req['pin'])) {
				$user->pass = password_hash($pass, PASSWORD_BCRYPT);
				UserRepository::update($user->id, 'pin', null);
				UserRepository::update($user->id, 'pass', $user->pass);
				UserService::signIn($user);
			} else {
				Util::badReq(1);
			}
		});
	}

	static function login() {
		RestController::create()->run(function () {
			if (!UserService::isUserSignedIn()) {
				$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
				if (!preg_match('/^09[0-9]{9}$/', $tel)) {
					Util::badReq(1);
				}
				$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
				if (strlen($pass) < 5) {
					Util::badReq(2);
				}
				$user = UserRepository::loadByTel($tel);
				if ($user) {
					if ($user->verifyPassword($pass)) {

						UserService::signIn($user);
						Util::redirect('/');
					} else {
						Util::badReq(3);
					}
				} else {
					self::signup();
				}
			}
		});
	}


	static function forgotPassword() {
		RestController::create()->run(function ($_req) {
			if (!UserService::isUserSignedIn()) {
				$tel = isset($_req['tel']) ? $_req['tel'] : '';
				if (!preg_match('/^09[0-9]{9}$/', $tel)) {
					Util::badReq(1);
				}
				$user = UserRepository::loadByTel($tel);
				if ($user) {
					if ($user->pin) {
						return;
					}
					$pin = mt_rand(10000, 99999);
					UserRepository::update($user->id, 'pin', $pin);
					SMSService::sendMessage($user->tel, "boilerplate
							برای تغییر رمز عبور از این کد استفاده کنید
							$pin
							");
				} else {
					Util::badReq(3);
				}
			}
		});
	}

	static function siteMap() {
		$con = Controller::create();
		$con->run(function () {
			$pages = PageRepository::select('hidden = 0');
			$urls = '';
			foreach ($pages as $page) {
				/* @var $page Page */
				$urls .= '<url>
    <loc>https://boilerplate.com/' . (ltrim($page->getLink(), '/')) . '</loc>
</url>';
			}
			$cats = CategoryRepository::select('hidden is false');
			foreach ($cats as $cat) {
				/* @var $cat Category */
				$urls .= '<url>
    <loc>https://boilerplate.com/' . (ltrim($cat->getLink(), '/')) . '</loc>
</url>';
			}
			$products = ProductRepository::select('hidden is false');
			foreach ($products as $prod) {
				/* @var $prod Product */
				$urls .= '<url>
    <loc>https://boilerplate.com/' . (ltrim($prod->getLink(), '/')) . '</loc>
</url>';
			}
			header("Content-Type: application/xml; charset=utf-8");
			echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://boilerplate.com/</loc>
    </url>
    ' . $urls . '
</urlset>';
		});
	}


	static function redirectLink($link_id) {
		$con = Controller::create();
		$con->run(function () use ($link_id, $con) {
			$link = ShortLinkService::find($link_id);
			if ($link) {
				$con->redirect($link);
			} else {
				$con->redirect('//shop.iranshik.ir');
			}
		});
	}
}
