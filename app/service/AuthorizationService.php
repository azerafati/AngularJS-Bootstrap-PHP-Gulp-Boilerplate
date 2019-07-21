<?php

class AuthorizationService {


    static public function hasPermission($permission) {
        $user = UserService::currentUser();

        return self::checkUserPermission($user->id, $permission);
    }

    static public function checkUserPermission($user_id, $permission) {
        $result = Repository::query('SELECT up.permission FROM user_group_permissions up JOIN user ON user.user_group_id=up.user_group_id AND user.id= :user_id WHERE up.permission =:perm ', [':user_id' => $user_id,
                                                                                                                                                                                               ':perm' => $permission]);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

}


