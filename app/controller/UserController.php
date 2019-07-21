<?php


	class UserController {

		static function logout() {
			RestController::create()->run(function () {
				if (UserService::isUserSignedIn())
					UserService::signOut();
				header('location: /');
			});
		}


		static function signup($_req, $ctrl) {
			if (!UserService::isUserSignedIn()) {
				$tel = isset($_req['mobile']) ? $_req['mobile'] : '';
				if (!preg_match('/^09[0-9]{9}$/', $tel)) {
					$ctrl->badRequest("WRONG_MOBILE");
				}
				$pass = isset($_req['password']) ? $_req['password'] : '';
				if (strlen($pass) < 5) {
					$ctrl->badRequest("SHORT_PASSWORD");
				}
				$user = UserRepository::loadByTel($tel);
				if (!$user) {
					$user = new User();
					$user->tel = $tel;
					$user->pass = password_hash($pass, PASSWORD_BCRYPT);
					$user = UserRepository::save($user);
					UserService::signIn($user);
					SMSService::sendMessage($user->tel, "به boilerplate خوش آمدید
اطلاع از تخفیف ها:
http://t.me/boilerplate");
				} else {
					if ($user->verifyPassword($pass)) {
						UserService::signIn($user);
					} else {
						$ctrl->badRequest("WRONG_PASSWORD");
					}
				}
			}
		}


		/**
		 * @param $_req
		 * @param $ctrl RestController
		 * @throws Exception
		 */
		static function login($_req, $ctrl) {
			if (!UserService::isUserSignedIn()) {
				$mobile = ($_req['mobile']) ?? '';
				if (!preg_match('/^09[0-9]{9}$/', $mobile)) {
					$ctrl->badRequest("WRONG_MOBILE");
				}
				$pass = ($_req['password']) ?? '';
				if (strlen($pass) < 5) {
					$ctrl->badRequest("SHORT_PASSWORD");
				}
				$user = UserRepository::loadByTel($mobile);
				//TODO PUT IN SYSTEM AGAIN && $user->active) {
				if ($user) {
					if ($user->verifyPassword($pass)) {
						UserService::signIn($user);
						self::getMe();
					} else {
						$ctrl->badRequest("WRONG_PASSWORD");
					}
				} else {
					UserController::signup($_req, $ctrl);
				}
			} else {
				$ctrl->badRequest("ALREADY_SIGNED_IN");
			}
		}


		static function getMe() {
			$curUser = UserService::currentUser();
			if ($curUser && $curUser->id) {

				$curUser = UserRepository::loadById($curUser->id);
				if (!$curUser) {
					echo json_encode(['is_guest' => true]);
				} else {
					$user = [
						'id' => $curUser->id,
						'name' => $curUser->getName(),
						'fname' => $curUser->fname,
						'lname' => $curUser->lname,
						'email' => $curUser->email,
						'gender' => $curUser->gender,
						'mobile' => $curUser->tel,
						'is_guest' => Util::boolify($curUser->guest),
						'rnd_img' => $curUser->rnd_img ?? null,
						'group_name' => $curUser->user_group_name ?? null,
						'group_id' => $curUser->user_group_id ?? null,
						'is_admin' => $curUser->guest ? false : AuthorizationService::hasPermission(Permission::ADMIN_DASHBOARD),
						'permissions' => UserGroupRepository::loadPermissionsById($curUser->user_group_id),

					];
					echo json_encode($user);
				}
			} else {
				echo json_encode(['is_guest' => true]);
			}
		}


	}
