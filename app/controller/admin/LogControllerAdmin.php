<?php


class LogControllerAdmin {

    /**
     * @param Category $cat
     */
    static function page($_req) {
        $total = LogRepository::countAllFiltered();
        $page = PageService::createPage($total, 30, $_req);
        $logs = LogRepository::loadAllFiltered($page, "log.*,SUBSTR(log.msg, 1, 20) as msg ,concat(user.fname,' ',user.lname) user_full_name, user.company user_company, user.known_as user_known_as", 'LEFT JOIN user on user.id=log.user_id');

        return PageService::jsonPage($page, $logs);
    }

}
