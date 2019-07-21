<?php

class UserService {

    /**
     *
     * @return User
     */
    static function createUserFromSession() {
        self::sessionStart();
        $user = checkSet($_SESSION, 'az_user', null);
        return $user;
    }

    static function authorize($userGroups) {
        if (!self::isUserSignedIn()) {
            return false;
        }
        if (in_array("admin", $userGroups) && !self::isUserAdmin()) {
            return false;
        }

        return true;
    }

    /**
     *
     * @return User
     */
    static function currentUser() {
        $user = self::createUserFromSession();
        if (!$user) {
            //check for cookie
            if (isset($_COOKIE['azerafati']) && !empty($_COOKIE['azerafati'])) {
                $cookie = $_COOKIE['azerafati'];
                $user = UserRepository::findByCookie($cookie);
                if ($user) {
                    UserService::signIn($user, false);
                } else {
                    //creating a guest user to hold information about current user
                    $guest = new User();
                    //$guest->cookie = $_COOKIE['azerafati'];
                    $guest->guest = true;
                    $guest->user_group_id = 1;
                    $user = UserRepository::save($guest);
                    UserService::signIn($user);
                }
            } else {
                //not returning null just skipping for another request which returns a cookie
                $user = new User();
                $user->user_group_id = 1;
                $user->guest = true;
            }
        }else{
            //on every request if user is already signed in we need to update last login date
            $user->update_last_login();
        }

        return $user;
    }

    /**
     * @return User
     */
    static function currentUserDB() {
        return UserRepository::loadById(self::currentUserId());
    }

    static function getBalance($user_id) {
        //$balance = PaymentRepository::balanceOfUser($user_id);
        // $sumPay = reset(UserRepository::getSumCreditOrdersPayments( $user_id )[0]);
        // $sumOrder = reset(OrderRepository::getSumOrdersOfUser( $user_id )[0]);
        return 1;
        //return $balance;
    }

    static function currentUserId() {
        $user =(object) self::currentUser();
        if ($user) {
            return ($user->id);
        } else {
            return false;
        }
    }

	static function isUserAdmin() {
		$currentUser = self::currentUser();

		//return $currentUser && $currentUser->admin;
		return $currentUser->guest ? false : AuthorizationService::hasPermission(Permission::ADMIN_DASHBOARD);

	}

    static function isUserSignedIn() {
        $currentUser = self::currentUser();
        //$currentUser instanceof User &&
        return (!$currentUser->guest);
    }

    /**
     * @param $user User
     * @param bool $updateCookie
     */
    static function signIn($user, $updateCookie = true) {
        $currentUser = self::createUserFromSession();
        if ($currentUser && $currentUser->id && $currentUser->id!=$user->id) {
            //merge possible guest user with the signin user
            UserRepository::mergeGuestWithUser($user, $currentUser);
        }
        self::sessionStart();
        //persist cookie
        if ($updateCookie) {
            UserRepository::insertCookie($user, $_COOKIE['azerafati']);
        }
        $user->update_last_login();
        $_SESSION['az_user'] = $user;
    }

    static function signOut() {
        self::sessionStart();
        $user = self::currentUser();
        UserRepository::removeCookie($user, $_COOKIE['azerafati']);
        session_destroy();
    }

    private static function sessionStart() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_name('azerafati');
			session_start();
        }
    }

    public static function saveProfileImage($img, $id) {

        $rnd = Util::generateRandomId(8);
        $vImg = Util::base64ToFile($img, AppRoot . '../res/img/user/' . $id . '/' . $rnd . '.jpg');
        $img = new Imagick($vImg);
        $img->setImageFormat('jpg');
        $img->setBackgroundColor('white');
        $img->setImageCompression(Imagick::COMPRESSION_JPEG);
        $img->setImageCompressionQuality(83);
        $profiles = $img->getImageProfiles("icc", true);
        $img->stripImage();
        if (!empty($profiles)) {
            $img->profileImage("icc", $profiles['icc']);
        }
        $img->thumbnailImage(500, 500, true, true);
        $img->writeimage($vImg);
        $img->clear();
        $img->destroy();
        UserRepository::update($id, 'rnd_img', $rnd);

    }

}