<?php


class UserGroupRepository extends Repository {
    static $tableName = "user_group";

    protected static function createFilter() {
        return new Filter([]

        );
    }

    /**
     *
     * @param int $user_id
     * @return UserGroup
     */
    public static function loadByUserId($user_id) {
        $group = self::query("select g.* from user_group g join user on user.user_group_id = g.id and user.id = :user_id ", [
            ":user_id" => $user_id
        ], UserGroup::class)[0];
        return $group;
    }

    /**
     *
     * @param UserGroup $group
     */
    public static function save($group) {

        return parent::executeQuery("insert into user_group (id,name,value_eu,value_tl,value_us) values(:id,:name,:value_eu,:value_tl,:value_us)
		ON DUPLICATE KEY UPDATE name = VALUES(name) , value_eu = VALUES(value_eu), value_tl = VALUES(value_tl), value_us = VALUES(value_us)", [
            "id" => $group->id,
            "name" => $group->name,
            "value_eu" => $group->value_eu,
            "value_tl" => $group->value_tl,
            "value_us" => $group->value_us
        ]);

    }


    public static function loadPermissionsById($group_id) {
        $result = Repository::query('SELECT up.* FROM user_group_permissions up WHERE up.user_group_id = :group_id', [':group_id' => $group_id]);
        return array_column($result, 'permission');
    }
}
