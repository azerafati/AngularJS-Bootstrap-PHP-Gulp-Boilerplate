<?php


class UserGroupControllerAdmin {


    static function loadAll() {
        $groups = UserGroupRepository::loadAll();
        echo json_encode($groups);

    }


    static function save($_req) {
        if (checkSet($_req, 'id')) {
            $group = UserGroupRepository::loadById($_req['id']);
        } else {
            $group = new UserGroup();
        }
        $group->name = $_req['name'];
        $group->value_eu = $_req['value_eu'] ?: 0;
        $group->value_tl = $_req['value_tl'] ?: 0;
        $group->value_us = $_req['value_us'] ?: 0;
        if (in_array(Permission::AGENCY, $_req['permissions'])) {
            $group->profit_percentage = $_req['profit_percentage'] ?: 0;
            $group->period = $_req['period'] ?: 0;
            $group->required_credit = $_req['required_credit'] ?: 0;
        } else {
            $group->profit_percentage = null;
            $group->period = null;
            $group->required_credit = null;
        }
        $group->instalment = checkSet($_req,'instalment',false);
        $group->cash_discount = checkSet($_req,'cash_discount',0);
        $group = UserGroupRepository::save($group);
        $groupPermissions = UserGroupRepository::getPermissions($group->id);
        Repository::executeQuery('DELETE FROM user_group_permissions WHERE user_group_id=:group', [':group' => $group->id]);
        if (checkSet($_req, 'permissions') && in_array(Permission::AGENCY, $_req['permissions'])) {
            foreach ($_req['permissions'] as $p) {
                if (strpos($p, Permission::AGENCY) !== false) {
                    Repository::insertInto('user_group_permissions', ['user_group_id' => $group->id,
                        'permission' => $p], false, false);
                }
            }
        } elseif (checkSet($_req, 'permissions')) {
            foreach ($_req['permissions'] as $p) {
                if (strpos($p, 'AGENCY') === false) {
                    Repository::insertInto('user_group_permissions', ['user_group_id' => $group->id,
                        'permission' => $p], false, false);
                }
            }
        }
        if (in_array(Permission::AGENCY,$_req['permissions']) && !in_array(Permission::AGENCY,$groupPermissions)) {
            //TODO update all users of this group to the agency_group_id
            $users_agency = self::loadUsersOfGroup($group->id);
            foreach ($users_agency as $user) {
                //creating default group for normal users
                AgencyUserGroupRepository::loadDefaultGroupOfAgency($user->id);
                //creating default admin group if it doesn't exist
                // and sets the user->agency_group_id to the default admin group
                AgencyUserGroupRepository::defaultAdminAgencyGroup($user->id, $group);
            }
        } elseif (in_array(Permission::AGENCY,$groupPermissions)) {
            UserRepository::executeQuery("UPDATE user SET user.agency_group_id = NULL WHERE user.user_group_id = :group", [":group" => $group->id]);
        }

    }


    static function remove() {
        RestControllerAdmin::create()->run(function () {
            if ($_REQUEST['id'] == 1) {
                Util::badReq();
            }
            $permissions = UserGroupRepository::getPermissions($_REQUEST['id']);
            if (in_array(Permission::AGENCY, $permissions)) {
                UserRepository::executeQuery("UPDATE user SET agency_group_id = NULL WHERE user.user_group_id = :group", [":group" => $_REQUEST['id']]);
            }
            UserRepository::executeQuery("UPDATE user SET user_group_id = 1 WHERE user.user_group_id = :group", [":group" => $_REQUEST['id']]);
            UserGroupRepository::delete($_REQUEST['id']);
        });
    }

    static function getPermissions($_req) {

        $permissions = UserGroupRepository::getPermissions($_req['id']);
        echo json_encode($permissions);
    }

    /**
     * @param $id
     * @return users of group
     */
    private static function loadUsersOfGroup($id) {
        $users = UserGroupRepository::loadUsersOfGroup($id);
        return $users;
    }


}
