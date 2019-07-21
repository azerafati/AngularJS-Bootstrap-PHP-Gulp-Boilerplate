<?php


class LogRepository extends Repository {
    static $tableName = "log";

    protected static function createFilter() {
        return new Filter([
            "q" => "msg like concat('%',:q,'%')"
        ]);
    }


    /**
     *
     * @param Log $log
     */
    public static function save($log) {
        parent::insert(array(
            'level' => $log->level,
            'msg' => $log->msg,
            'user_id' => $log->user_id,
            'type' => $log->type
        ), [
            "created" => 'NOW()'
        ], false);
    }

}
